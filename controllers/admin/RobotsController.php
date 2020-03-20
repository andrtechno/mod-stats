<?php

namespace panix\mod\stats\controllers\admin;

use panix\engine\CMS;
use panix\mod\stats\components\StatsHelper;
use panix\mod\stats\components\StatsController;
use Yii;

class RobotsController extends StatsController
{

    public function actionIndex()
    {
        $this->pageName = Yii::t('stats/default', 'ROBOTS');
        $this->breadcrumbs = [
            [
                'label' => Yii::t('stats/default', 'MODULE_NAME'),
                'url' => ['/admin/stats']
            ],
            $this->pageName
        ];
        /** @var \yii\db\Query $query */
        $query = $this->query;
        $query->select(['COUNT(i) as count', 'MAX(i) as count_max', 'date']);
        $query->andWhere(['>=', 'date', $this->sdate]);
        $query->andWhere(['<=', 'date', $this->fdate]);
        foreach ($this->robo as $val) {





            $zs = "";
            $pf = "";
            if (empty($val))
                continue;



            if (isset($this->rbdn[$val])) {

                foreach ($this->rbdn[$val] as $vl) {

                   // $zs .= $pf . "LOWER(user) LIKE '%" . mb_strtolower($vl) . "%'";
                   // $pf = " OR ";
                    $query->andWhere(['like', 'LOWER(user)', mb_strtolower($vl)]);

                }
               // CMS::dump($this->rbdn[$val]);
              //  var_dump($val);
            }
            if (isset($this->hbdn[$val]))
                foreach ($this->hbdn[$val] as $vl) {
                    //$zs .= $pf . "LOWER(host) LIKE '%" . mb_strtolower($vl) . "%'";
                   // $pf = " OR ";
                    $query->andWhere(['like', 'LOWER(host)', mb_strtolower($vl)]);
                }


            //   $res = $this->query->createCommand()->queryOne();
            // print_r($res);die;
            //   echo $this->query->createCommand()->rawSql;die;


            //print_r($res);die;


            //$sql = "SELECT COUNT(i), MAX(i) FROM {$this->tableSurf} WHERE (" . $zs . ") AND " . $this->_zp2 . " dt >= '$this->sdate' AND dt <= '$this->fdate'";

//

            //$r = $cmd->queryOne();
            $r = $query->createCommand()->queryOne();

            $d = $r['count_max'];

            $cnt[$val] = $r['count'];

            if ($cnt[$val] > 0) {

                $query = new \yii\db\Query;
                $query->from($this->tableSurf);
                $query->where(['i' => $d]);
                $query->select(['date', 'time']);

                // $z2 = "SELECT dt,tm FROM {{surf}} WHERE i = " . $d;
                // $cmd2 = $this->db->createCommand($z2);
                // $r2 = $cmd2->queryOne();
                $r2 = $query->createCommand()->queryOne();

                $ff_date[$val] = $r2['date'] . " &nbsp;<span style='color:#de3163'>" . $r2['time'] . "</span>";
            } else {
                $ff_date[$val] = "0 &nbsp;<span style='color:#de3163'>0</span>";
            }

        }
        $cmd = $query->createCommand()->rawSql;
        //echo $cmd;
       // die;


        arsort($cnt);
        $mmx = max($cnt);
        $cn = array_sum($cnt);
        $result = [];
        $k = 0;
        foreach ($cnt as $val => $co) {
            if ($co <> 0) {
                $k++;


                $result[] = [
                    'num' => $k,
                    'bot' => '<a target=_blank href="robots/detail?s_date=' . $this->sdate . '&f_date=' . $this->fdate . '&qs=' . $val . '">' . $val . '</a>',
                    'visit' => $ff_date[$val],
                    'count' => $co,
                    'progressbar' => $this->progressBar(ceil(($co * 100) / $mmx), number_format((($co * 100) / $cn), 1, '.', '')),
                    'detail' => StatsHelper::linkDetail("robots/detail?s_date={$this->sdate}&f_date={$this->fdate}&qs={$val}")
                ];
                ?>

                <?php

            }
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        /*  $dataProvider = new CArrayDataProvider($result, array(
              'sort' => array(
                  'attributes' => array(
                      'bot',
                      'visit',
                      'count'
                  ),
              ),
              'pagination' => array(
                  'pageSize' => 10,
              ),
          ));*/
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'cnt' => $cnt,
            'cn' => $cn,
            'ff_date' => $ff_date,
            'mmx' => $mmx,
        ]);
    }

    public function actionDetail()
    {
        $qs = $_GET['qs'];
        $this->pageName = Yii::t('stats/default', 'ROBOTS');
        $this->breadcrumbs = array(
            Yii::t('stats/default', 'MODULE_NAME') => array('/admin/stats'),
            $this->pageName => array('/admin/stats/robots'),
            $qs
        );


        $zs = "";
        $pf = "";
        if (isset($this->rbdn[$qs]))
            foreach ($this->rbdn[$qs] as $vl) {
                $zs .= $pf . "LOWER(user) LIKE '%" . mb_strtolower($vl) . "%'";
                $pf = " OR ";
            }
        if (isset($this->hbdn[$qs]))
            foreach ($this->hbdn[$qs] as $vl) {
                $zs .= $pf . "LOWER(host) LIKE '%" . mb_strtolower($vl) . "%'";
                $pf = " OR ";
            }
        // $res = mysql_query("SELECT day,dt,tm,refer,ip,proxy,host,lang,user,req FROM " . $tablePref . "surf WHERE (" . $zs . ") AND " . $zp2 . " dt >= '$s_date' AND dt <= '$f_date' ORDER BY i DESC");
        $sql = "SELECT day,dt,tm,refer,ip,proxy,host,lang,user,req FROM {{surf}} WHERE (" . $zs . ") AND " . $this->_zp2 . " dt >= '$this->sdate' AND dt <= '$this->fdate' ORDER BY i DESC";
        $cmd = $this->db->createCommand($sql);

        $r = $cmd->queryAll();
        $this->render('detail', array(
            'items' => $r,
        ));
    }

}
