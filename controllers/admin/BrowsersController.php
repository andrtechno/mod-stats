<?php

namespace panix\mod\stats\controllers\admin;

use Yii;
use panix\engine\CMS;
use panix\engine\Html;
use panix\mod\stats\components\StatsHelper;
use panix\mod\stats\components\StatsController;

class BrowsersController extends StatsController
{

    public function actionIndex()
    {
        $this->pageName = Yii::t('stats/default', 'BROWSERS');
        $this->breadcrumbs = [
            [
                'label' => Yii::t('stats/default', 'MODULE_NAME'),
                'url' => ['/stats']
            ],
            $this->pageName
        ];

        /** @var \panix\mod\stats\components\Query $query */
        $query = $this->query;
        $query->select(['user', 'ip']);
        $query->where(['>=', 'date', $this->sdate]);
        $query->andWhere(['<=', 'date', $this->fdate]);
        foreach ($this->_zp_queries as $q) {
            $query->andWhere($q);
        }
        $browserList = [];
        $ipList = [];
        $browserCount = 1;
        if ($this->sort == "hi") {
            $command = $query->createCommand();
            foreach ($command->queryAll() as $row) {
                $gb = StatsHelper::getBrowser($row['user']);
                $browserList[$gb] = $browserCount;
                $browserCount++;
            }
        } else {
            $query->groupBy(['ip', 'user']);
            $command = $query->createCommand();
            foreach ($command->queryAll() as $row) {
                $gb = StatsHelper::getBrowser($row['user']);
                $browserList[$gb] = [];
                if (!isset($ipmas[$row['ip']][$gb])) {
                    $browserList[$gb] = $browserCount;
                    $ipList[$row['ip']][$gb] = 1;
                }
                $browserCount++;
            }
        }


        $vse = 0;
        $k = 0;
        $mmx = 0;
        $cnt = 0;
        if ($browserList) {
            arsort($browserList);
            $mmx = max($browserList);
            $cnt = array_sum($browserList);
        }
        $pie = [];
        $helper = new StatsHelper;

        // print_r($bmas);
        //die();

        foreach ($browserList as $brw => $val) {

            $k++;
            $vse += $val;
            $this->result[] = [
                'num' => $k,
                'browser' => $helper->browserName($brw),
                'val' => $val,
                'progressbar' => $this->progressBar(ceil(($val * 100) / $mmx), number_format((($val * 100) / $cnt), 1, ',', ''), (($this->sort == "hi") ? "success" : "warning")),
                'detail' => StatsHelper::linkDetail('/admin/stats/browsers/detail?s_date=' . $this->sdate . '&f_date=' . $this->fdate . '&brw=' . (empty($brw) ? "другие" : $brw) . "&sort=" . (empty($this->sort) ? "ho" : $this->sort)),
            ];
            $pie[] = [
                'name' => $helper->browserName($brw),
                'y' => ceil(($val * 100) / $mmx),
                'hosts' => $val
                //  'sliced'=> true,
                //'selected'=> true
            ];
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $this->result,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView1331312132()
    {
        $this->pageName = 'dsadsa';
        $brw = $_GET['brw'];


        $vse = 0;
        $k = 0;
        //$db = Yii::$app->db;
        if ($this->sort == "hi") {
            $sql = "SELECT user, COUNT(user) cnt FROM {$this->tableSurf} WHERE";
            $sql .= $this->_zp . " AND date >= '$this->sdate' AND date <= '$this->fdate' " . (isset($brw) ? StatsHelper::GetBrw($brw) : "") . " GROUP BY user ORDER BY 2 DESC";
            $res = $this->db->createCommand($sql);
            $full_sql = "SELECT SUM(t.cnt) AS cnt FROM (" . $sql . ") t";
            $r = $this->db->createCommand($full_sql);
        } else {

            $sql = "CREATE TEMPORARY TABLE {{%tmp_surf}} SELECT ip, user FROM {$this->tableSurf} WHERE";
            $sql .= $this->_zp . " AND date >= '$this->sdate' AND date <= '$this->fdate' " . (isset($brw) ? StatsHelper::GetBrw($brw) : "") . " GROUP BY ip" . (!isset($brw) ? ",user" : "");
            $sql2 = "SELECT user, COUNT(user) cnt FROM {{%tmp_surf}} GROUP BY USER ORDER BY 2 DESC";
            $res = $this->db->createCommand($sql);

            $transaction = $this->db->beginTransaction();
            try {
                $this->db->createCommand($sql2)->execute();
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
            }


            $z3 = "SELECT SUM(t.cnt) AS cnt FROM (" . $sql2 . ") t";


            $transaction2 = $this->db->beginTransaction();
            try {
                $this->db->createCommand($sql)->execute();
                $transaction2->commit();
            } catch (Exception $e) {
                $transaction2->rollBack();
            }

            $r = $this->db->createCommand($z3);
        }
        $smd = $r->queryRow();
        $cnt = $smd['cnt'];
        if (!empty($brw)) {
            switch ($brw) {
                case "ie.png":
                    $browserName = "MS Internet Explorer";
                    break;
                case "opera.png":
                    $browserName = "Opera";
                    break;
                case "firefox.png":
                    $browserName = "Firefox";
                    break;
                case "chrome.png":
                    $browserName = "Google Chrome";
                    break;
                case "mozilla.png":
                    $browserName = "Mozilla";
                    break;
                case "safari.png":
                    $browserName = "Apple Safari";
                    break;
                case "mac.png":
                    $browserName = "Macintosh";
                    break;
                case "maxthon.png":
                    $browserName = "Maxthon (MyIE)";
                    break;
                default:
                    $browserName = "другие";
                    break;
            }
        }

        return $this->render('view', [
            'items' => $res->queryAll(),
            'cnt' => $cnt,
            'max' => $max,
            'browserName' => $browserName,
            'vse' => $vse,
            'k' => $k,
            // 'pos' => $pos
        ]);
    }

    public function actionDetail()
    {


        $pz = 0;
       // $sql = "SELECT * FROM {$this->tableSurf} WHERE date >= '$this->sdate' AND date <= '$this->fdate' " . StatsHelper::GetBrw(Yii::$app->request->get('brw')) . (($pz == 1) ? " AND" . $this->_zp : "") . " " . (($this->sort == "ho") ? "GROUP BY ip" : "") . " ORDER BY i DESC";
       // $cmd = $this->db->createCommand($sql);

        /** @var \panix\mod\stats\components\Query $query */
        $query = $this->query;
        $query->select('*');
        if(Yii::$app->request->get('s_date'))
            $query->where(['>=', 'date', $this->sdate]);
        if(Yii::$app->request->get('f_date'))
            $query->andWhere(['<=', 'date', $this->fdate]);
        $query->browser(Yii::$app->request->get('brw'));
       // echo $query->createCommand()->rawSql;die;
       // if ($brw) {
            foreach ($this->_zp_queries as $q) {
                $query->andWhere($q);
            }
      //  }
        if ($this->sort == 'ho')
            $query->groupBy('ip');

        $query->orderBy(['i' => SORT_DESC]);

        //   echo $cmd->rawSql;
        // echo '<br><br><br><bR>';
//echo StatsHelper::GetBrw(Yii::$app->request->get('brw')) . (($pz == 1) ? " AND" . $this->_zp : "");
        //  echo '<br><br><br><bR>';

        // echo $query->createCommand()->rawSql;
        //  die;
        $items = $query->createCommand()->queryAll();


        foreach ($items as $row) { //StatsHelper::$MONTH[substr($row['dt'], 4, 2)]
            $ip = CMS::ip($row['ip']);
            //$ip = $row['ip'];

            if ($row['proxy'] != "") {
                $ip .= '<br>';
                $ip .= Html::a('через proxy', '?item=ip&qs=' . $row['proxy'], ['target' => '_blank']);
            }

            $this->result[] = array(
                'date' => StatsHelper::$DAY[$row['day']] . ' ' . CMS::date(strtotime($row['date']),false) .' '.$row['time'],
                'time' => $row['time'],
                'refer' => StatsHelper::renderReferrer($row['refer']),
                'ip' => $ip,
                'host' => StatsHelper::getRowHost($row['ip'], $row['proxy'], $row['host'], $row['lang']),
                'user_agent' => StatsHelper::getRowUserAgent($row['user'], $row['refer']),
                'page' => Html::a($row['req'], $row['req'], ['target' => '_blank']),
            );
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $this->result,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        /*$dataProvider = new CArrayDataProvider($this->result, array(
            'sort' => array(
                // 'defaultOrder'=>'id ASC',
                'attributes' => array(
                    'date',
                ),
            ),
            'pagination' => array(
                'pageSize' => 101,
            ),
        ));*/

        return $this->render('detail', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
