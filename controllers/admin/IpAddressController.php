<?php

namespace panix\mod\stats\controllers\admin;

use panix\mod\stats\models\StatsSurf;
use Yii;
use panix\engine\CMS;
use panix\engine\Html;
use panix\mod\stats\components\StatsHelper;
use panix\mod\stats\components\StatsController;

class IpAddressController extends StatsController
{

    public function actionIndex()
    {
        $this->pageName = Yii::t('stats/default', 'IP_ADDRESS');
        $this->breadcrumbs = [
            [
                'label' => Yii::t('stats/default', 'MODULE_NAME'),
                'url' => ['/admin/stats']
            ],
            $this->pageName
        ];
        $tableSurf = StatsSurf::tableName();
        $sql = "SELECT ip, COUNT(ip) cnt FROM {$tableSurf} WHERE";
        $sql .= $this->_zp . " AND date >= '$this->sdate' AND date <= '$this->fdate' GROUP BY ip ORDER BY 2 DESC";

        $res = $this->db->createCommand($sql)->queryAll(false);

        $sql2 = "SELECT SUM(t.cnt) AS count FROM (" . $sql . ") t";


        $total_cmd = $this->db->createCommand($sql2);
        $total = $total_cmd->queryColumn(false);

//echo $total[0];
        $k = 0;
        $vse = 0;
        foreach ($res as $row) {

            if ($k == 0)
                $max = $row[1];
            $k++;
            $vse += $row[1];
            //  if ($row[0] != "unknown")
            //      $ipz = "<a target=_blank href=\"?tz=1&pz=1&item=ip&s_date=" . $this->sdate . "&f_date=" . $this->fdate . "&qs=" . $row[0] . "\">" . $row[0] . "</a>";
            //  else
            //      $ipz = "неизвестно";

            $this->result[] = [
                'num' => $k,
                'ip' => CMS::ip($row[0]), //$ipz,
                'val' => $row[1],
                'progressbar' => $this->progressBar(ceil(($row[1] * 100) / $max), number_format((($row[1] * 100) / $total[0]), 1, ',', '')),
                'detail' => StatsHelper::linkDetail("/admin/stats/ipaddress/detail/?tz=1&pz=1&s_date=" . $this->sdate . "&f_date=" . $this->fdate . "&qs=" . $row[0])
            ];
        }


        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $this->result,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        /*$dataProvider = new CArrayDataProvider($this->result, array(
            'sort' => array(
                // 'defaultOrder'=>'ip ASC',
                'attributes' => array(
                    'ip',
                    'val'
                ),
            ),
            'pagination' => array('pageSize' => 10)
        ));*/
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionDetail()
    {

        $qs = $_GET['qs'];
        $country = CMS::getCountryNameByIp($qs);
        $this->pageName = $qs . ' ' . $country;
        $title = CMS::ip($qs, 1);
        $title .= ' (' . $country . ')';

        $this->breadcrumbs = array(
            Yii::t('stats/default', 'MODULE_NAME') => ['/admin/stats'],
            Yii::t('stats/default', 'IP_ADDRESS') => ['/admin/stats/ip-address'],
            $qs
        );


        $item = 'ip';
        $tz = $_GET['tz'];

        $sql = "SELECT * FROM {$this->tableSurf} WHERE (" . $item . " LIKE '" . (($tz == 1) ? "" : "%") . addslashes($qs) . (($tz == 1 or $tz == 7) ? "" : "%") . "') AND dt >= '$this->sdate' AND dt <= '$this->fdate' " . (($pz == 1) ? "AND" . $this->_zp : "") . " " . (($this->sort == "ho") ? "GROUP BY " . (($tz == 7) ? "host" : "ip") : "") . " ORDER BY i DESC";
        $res = $this->db->createCommand($sql);
        foreach ($res->queryAll() as $row) {


            $ip = CMS::ip($row['ip']);

            if ($row['proxy'] != "") {
                $ip .= '<br>';
                $ip .= Html::a('через proxy', '?item=ip&qs=' . $row['proxy'], ['target' => '_blank']);
            }

            $this->result[] = array(
                'date' => StatsHelper::$DAY[$row['day']] . ' ' . CMS::date($row['date'] . ' ' . $row['time']),
                // 'date' => StatsHelper::$DAY[$row['day']] . ' ' . $row['dt'],
                'time' => $row['time'],
                'refer' => StatsHelper::renderReferer($row['refer']),
                'ip' => $ip,
                'host' => StatsHelper::getRowHost($row['ip'], $row['proxy'], $row['host'], $row['lang']),
                'user_agent' => StatsHelper::getRowUserAgent($row['user'], $row['refer']),
                'page' => Html::a($row['req'], $row['req'], ['target' => '_blank']),
            );
        }

        $dataProvider = new CArrayDataProvider($this->result, array(
            'sort' => array(
                // 'defaultOrder'=>'ip ASC',
                'attributes' => array(
                    'date',
                    'time',
                    'refer',
                    'page'
                ),
            ),
            'pagination' => array('pageSize' => 10)
        ));
        $this->render('detail', [
            'dataProvider' => $dataProvider,
            'title' => $title
        ]);
    }

}
