<?php

namespace panix\mod\stats\controllers\admin;

use Yii;
use panix\engine\Html;
use panix\mod\stats\components\StatsHelper;
use panix\mod\stats\components\StatsController;
class VisitPageController extends StatsController
{


    public function actionIndex()
    {
        $this->pageName = Yii::t('stats/default', 'PAGEVISIT');


        $this->breadcrumbs = [
            [
                'label' => Yii::t('stats/default', 'MODULE_NAME'),
                'url' => ['/admin/stats']
            ],
            $this->pageName
        ];

        $stats = Yii::$app->stats->initRun();
        $zp = $stats['zp'];

        if ($this->sort == "hi") {
            $z = "SELECT req, COUNT(req) cnt FROM {$this->tableSurf} WHERE";
            $z .= $zp . " AND date >= '$this->sdate' AND date <= '$this->fdate' GROUP BY req ORDER BY 2 DESC";
            $res = $this->db->createCommand($z)->queryAll();

            $z2 = "SELECT SUM(t.cnt) AS cnt FROM (" . $z . ") t";
            $r = $this->db->createCommand($z2)->queryOne();
        } else {
            $z = "CREATE TEMPORARY TABLE IF NOT EXISTS {{%tmp_surf}} SELECT ip, req FROM {$this->tableSurf} WHERE";
            $z .= $zp . " AND date >= '$this->sdate' AND date <= '$this->fdate' GROUP BY ip, req";
            $z2 = "SELECT req, COUNT(req) cnt FROM {{%tmp_surf}} GROUP BY req ORDER BY 2 DESC";

            $transaction = $this->db->beginTransaction();
            try {
                $this->db->createCommand($z)->execute();
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
            }


            $res = $this->db->createCommand($z2)->queryAll();

            $z3 = "SELECT SUM(t.cnt) AS cnt FROM (" . $z2 . ") t";

            $transaction2 = $this->db->beginTransaction();
            try {
                $this->db->createCommand($z)->execute();
                $transaction2->commit();
            } catch (Exception $e) {
                $transaction2->rollBack();
            }

            $r = $this->db->createCommand($z3)->queryOne();
        }

        $cnt = $r['cnt'];


        $k = 0;


        foreach ($res as $row) {
            if ($k == 0)
                $max = $row['cnt'];
            if ($row['req'] == "")
                $row['req'] = "<span style='color:grey'>неизвестно</span>";
            $k++;


            $result[] = array(
                'num' => $k,
                'req' => Html::a($row['req'], $row['req'],['traget' => '_blank']),
                'count' => $row['cnt'],
                'graphic' => $this->progressBar(ceil((($row['cnt'] * 100) / $max)), number_format((($row['cnt'] * 100) / $cnt), 1, '.', ''), (($this->sort == "hi") ? "success" : "warning")), //"<img align=left src=/stats/px" . (($this->sort == "hi") ? "h" : "u") . ".gif width=" . ceil(($row['cnt'] * 100) / $max) . " height=11 border=0>",
                'detail' => StatsHelper::linkDetail("?pz=1&tz=1&item=req&s_date=" . $this->sdate . "&f_date=" . $this->fdate . "&qs=" . urlencode($row['req']) . "&sort=" . (empty($this->sort) ? "ho" : $this->sort))
            );
        }


        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        /* $dataProvider = new CArrayDataProvider($result, array(
             'sort' => array(
                 'attributes' => array(
                     'req',
                     'count',
                 ),
             ),
             'pagination' => array(
                 'pageSize' => 10,
             ),
         ));*/

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

}
