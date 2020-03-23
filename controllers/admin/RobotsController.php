<?php

namespace panix\mod\stats\controllers\admin;

use panix\engine\CMS;
use panix\engine\Html;
use panix\mod\stats\components\StatsHelper;
use panix\mod\stats\components\StatsController;
use Yii;
use yii\db\Query;

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
        if (Yii::$app->request->get('s_date') && Yii::$app->request->get('f_date')) {
            $query->andWhere(['>=', 'date', $this->sdate]);
            $query->andWhere(['<=', 'date', $this->fdate]);
        }

        foreach ($this->robo as $val) {

            if (empty($val))
                continue;

            if (isset($this->rbdn[$val])) {
                $userList = [];
                foreach ($this->rbdn[$val] as $vl) {
                    $userList[] = mb_strtolower($vl);
                    // $re_query->andWhere(['like', 'LOWER(user)', mb_strtolower($vl)]);

                }
                $query->where(['like', 'LOWER(user)', $userList]);
            }
            if (isset($this->hbdn[$val])) {
                $hostList = [];
                foreach ($this->hbdn[$val] as $vl) {
                    $hostList[] = mb_strtolower($vl);

                }
                $query->andWhere(['like', 'LOWER(host)', $hostList]);
            }

            $r = $query->createCommand()->queryOne();

            $d = $r['count_max'];

            $cnt[$val] = $r['count'];

            if ($cnt[$val] > 0) {
                $query1 = new \yii\db\Query;
                $query1->from($this->tableSurf);
                $query1->where(['i' => $d]);
                $query1->select(['date', 'time']);

                // $z2 = "SELECT dt,tm FROM {{surf}} WHERE i = " . $d;
                // $cmd2 = $this->db->createCommand($z2);
                // $r2 = $cmd2->queryOne();
                $r2 = $query1->createCommand()->queryOne();

                $ff_date[$val] = $r2['date'] . " &nbsp;<span style='color:#de3163'>" . $r2['time'] . "</span>";
            } else {
                $ff_date[$val] = "0 &nbsp;<span style='color:#de3163'>0</span>";
            }

        }
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
                    'bot' => Html::a($val, ['detail', 's_date' => $this->sdate, 'f_date' => $this->fdate, 'qs' => $val], ['target' => '_blank']),
                    'visit' => $ff_date[$val],
                    'count' => $co,
                    'progressbar' => $this->progressBar(ceil(($co * 100) / $mmx), number_format((($co * 100) / $cn), 1, '.', '')),
                    'detail' => StatsHelper::linkDetail(['detail', 's_date' => $this->sdate, 'f_date' => $this->fdate, 'qs' => $val])
                ];


            }
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

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
        $qs = Yii::$app->request->get('qs');
        $this->pageName = $qs;

        $this->breadcrumbs[] = [
            'label' => Yii::t('stats/default', 'MODULE_NAME'),
            'url' => ['/admin/stats']
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('stats/default', 'ROBOTS'),
            'url' => ['/admin/stats/robots']
        ];
        $this->breadcrumbs[] = $qs;
        $zs = "";
        $pf = "";
        /** @var Query $query */
        $query = $this->query;
        $query->select('*');
        if (Yii::$app->request->get('s_date') && Yii::$app->request->get('f_date')) {
            $query->where(['>=', 'date', $this->sdate]);
            $query->andWhere(['<=', 'date', $this->fdate]);
        }
        if (isset($this->rbdn[$qs]))
            foreach ($this->rbdn[$qs] as $vl) {
                $query->andWhere(['LIKE', 'LOWER(user)', mb_strtolower($vl)]);
                $zs .= $pf . "LOWER(user) LIKE '%" . mb_strtolower($vl) . "%'";
                $pf = " OR ";
            }
        if (isset($this->hbdn[$qs]))
            foreach ($this->hbdn[$qs] as $vl) {
                $query->andWhere(['LIKE', 'LOWER(host)', mb_strtolower($vl)]);
                $zs .= $pf . "LOWER(host) LIKE '%" . mb_strtolower($vl) . "%'";
                $pf = " OR ";
            }

        $query->orderBy(['i' => SORT_DESC]);
        $command = $query->createCommand();
        $result = [];
        foreach ($command->queryAll() as $data) {
            $result[] = [
                'date' => StatsHelper::$DAY[$data['day']] . $data['date'],
                'time' => $data['time'],
                'refer' => StatsHelper::Ref($data['refer']),
                'ip' => $data['ip'],
                'host' => StatsHelper::getRowHost($data['ip'], $data['proxy'], $data['host'], $data['lang']),
                'user_agent' => $data['user'],
                'req' => $data['req'],
            ];

        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);


        // $res = mysql_query("SELECT day,dt,tm,refer,ip,proxy,host,lang,user,req FROM " . $tablePref . "surf WHERE (" . $zs . ") AND " . $zp2 . " dt >= '$s_date' AND dt <= '$f_date' ORDER BY i DESC");
        //$sql = "SELECT day,date,time,refer,ip,proxy,host,lang,user,req FROM {$this->tableSurf} WHERE (" . $zs . ") AND " . $this->_zp2 . " date >= '$this->sdate' AND date <= '$this->fdate' ORDER BY i DESC";

        return $this->render('detail', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
