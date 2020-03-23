<?php

namespace panix\mod\stats\controllers\admin;

use panix\mod\stats\components\Query;
use panix\mod\stats\models\StatsSurf;
use Yii;
use panix\engine\CMS;
use panix\engine\Html;
use panix\mod\stats\components\StatsHelper;
use panix\mod\stats\components\StatsController;
use yii\data\ArrayDataProvider;

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
        /** @var \panix\mod\stats\components\Query $query */
        $query = $this->query;
        $query->select(['ip','COUNT(ip) cnt']);
        $query->where(['>=', 'date', $this->sdate]);
        $query->andWhere(['<=', 'date', $this->fdate]);
        foreach ($this->_zp_queries as $q) {
            $query->andWhere($q);
        }
        $query->groupBy(['ip']);

        $tableSurf = StatsSurf::tableName();

        $res = $query->createCommand()->queryAll(false);
        $queryTotal = (new Query())->select(["SUM({$tableSurf}.cnt) AS count"])->from([$tableSurf=>$query]);
        $total = $queryTotal->createCommand()->queryColumn();



       // print_r($total);die;
//echo $total[0];
        $k = 0;
        $vse = 0;
      //  die;
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
                'ip' => CMS::ip($row[0]),
                'val' => $row[1],
                'progressbar' => $this->progressBar(ceil(($row[1] * 100) / $max), number_format((($row[1] * 100) / $total[0]), 1, ',', '')),
                'detail' => StatsHelper::linkDetail(['detail', 's_date' => $this->sdate, 'f_date' => $this->fdate, 'qs' => $row[0], 'tz' => 1, 'pz' => 1])
            ];
        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->result,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionDetail()
    {

        $qs = Yii::$app->request->get('qs');

        $this->pageName = $qs;
        $title = CMS::ip($qs);

        $this->breadcrumbs[]=[
            'label'=>Yii::t('stats/default', 'MODULE_NAME'),
            'url'=>['/admin/stats']
        ];
        $this->breadcrumbs[]=[
            'label'=>Yii::t('stats/default', 'IP_ADDRESS'),
            'url'=>['/admin/stats/ip-address']
        ];
        $this->breadcrumbs[]=$this->pageName;
        $item = 'ip';
        $tz = Yii::$app->request->get('tz');
        $pz = Yii::$app->request->get('pz');


        /** @var \panix\mod\stats\components\Query $query */
        $query = $this->query;
        $query->select('*');
        $query->where(['ip'=>$qs]);
        $query->andWhere(['>=', 'date', $this->sdate]);
        $query->andWhere(['<=', 'date', $this->fdate]);
        $query->orderBy(['i'=>SORT_DESC]);
        if($this->sort=='ho'){
            $query->groupBy(['ip']);
            if($tz==7){
                $query->groupBy(['host']);
            }

        }
        if($pz==1) {
            foreach ($this->_zp_queries as $q) {
                $query->andWhere($q);
            }
        }
        $command  = $query->createCommand();
       // echo $query->createCommand()->rawSql;
       // echo '<br><br><br><br><br>';
        $sql = "SELECT * FROM {$this->tableSurf} WHERE (" . $item . " LIKE '" . (($tz == 1) ? "" : "%") . addslashes($qs) . (($tz == 1 or $tz == 7) ? "" : "%") . "') AND date >= '$this->sdate' AND date <= '$this->fdate' " . (($pz == 1) ? "AND" . $this->_zp : "") . " " . (($this->sort == "ho") ? "GROUP BY " . (($tz == 7) ? "host" : "ip") : "") . " ORDER BY i DESC";
       // $res = $this->db->createCommand($sql);
        //echo $sql;die;
        foreach ($command->queryAll() as $row) {


            $ip = CMS::ip($row['ip']);

            if ($row['proxy'] != "") {
                $ip .= '<br>';
                $ip .= Html::a('через proxy', '?item=ip&qs=' . $row['proxy'], ['target' => '_blank']);
            }

            $this->result[] = array(
                'date' => StatsHelper::$DAY[$row['day']] . ' ' . CMS::date(strtotime($row['date'] . ' ' . $row['time'])),
                'refer' => StatsHelper::renderReferrer($row['refer']),
                'ip' => $ip,
                'host' => StatsHelper::getRowHost($row['ip'], $row['proxy'], $row['host'], $row['lang']),
                'user_agent' => StatsHelper::getRowUserAgent($row['user'], $row['refer']),
                'page' => Html::a($row['req'], $row['req'], ['target' => '_blank']),
            );
        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->result,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        return $this->render('detail', [
            'dataProvider' => $dataProvider,
            'title' => $title
        ]);
    }

}
