<?php

namespace panix\mod\stats;

use Yii;
use panix\engine\Html;

class Module extends \panix\engine\WebModule {

    public $icon = 'stats';

    public function afterInstall() {

        /* Yii::$app->settings->set('stats', array(
          'param' => 'param',
          )); */
        Yii::$app->database->import($this->id);

        return parent::afterInstall();
    }

    public function afterUninstall() {
        Yii::$app->settings->clear('stats');
        Yii::$app->db->createCommand()->dropTable(StatsSurf::model()->tableName());
        Yii::$app->db->createCommand()->dropTable(StatsMainp::model()->tableName());
        Yii::$app->db->createCommand()->dropTable(StatsMainHistory::model()->tableName());

        return parent::afterUninstall();
    }

    public function getAdminMenu() {
        $c =Yii::$app->controller->id;
        $a =Yii::$app->controller->action->id;
        return [
            'modules' => [
                'items' => [
                    [
                        'label' => Yii::t('stats/default', 'MODULE_NAME'),
                        'url' => ['/admin/stats'],
                        'icon' => $this->icon,
                        'items' => [
                            [
                                'label' => 'dsa',
                                'url' => ['/admin/stats'],
                                'icon' => Html::icon('icon-stats')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'BROWSERS'),
                                'url' => array('/admin/stats/browsers'),
                                'active' => ($c == 'admin/browsers') ? true : false,
                                'icon' => Html::icon('icon-firefox')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'TIMEVISIT'),
                                'url' => array('/admin/stats/timevisit'),
                                'active' => ($c == 'admin/timevisit') ? true : false,
                                'icon' => Html::icon('icon-time')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'PAGEVISIT'),
                                'url' => array('/admin/stats/pagevisit'),
                                'active' => ($c == 'admin/pagevisit') ? true : false,
                                'icon' => Html::icon('icon-monitor-stats')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'ROBOTS'),
                                'url' => array('/admin/stats/robots'),
                                'active' => ($c == 'admin/robots') ? true : false,
                                'icon' => Html::icon('icon-android')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'REF_DOMAIN'),
                                'url' => array('/admin/stats/refdomain'),
                                'active' => ($c == 'admin/refdomain') ? true : false,
                                'icon' => Html::icon('icon-http')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'IP_ADDRESS'),
                                'url' => array('/admin/stats/ipaddress'),
                                'active' => ($c == 'admin/ipaddress') ? true : false,
                                'icon' => Html::icon('icon-ip')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'Поисковые запросы'),
                                'url' => array('/admin/stats/searchquery'),
                                'active' => ($c == 'admin/searchquery' && $a == 'index') ? true : false,
                                'icon' => Html::icon('icon-search')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'Поисковые системы'),
                                'url' => array('/admin/stats/searchquery/system'),
                                'active' => ($c == 'admin/searchquery' && $a == 'system') ? true : false,
                                'icon' => Html::icon('icon-search')
                            ],
                        ]
                    ]
                ]
            ]
        ];
    }

    public function getAdminSideba2r() {
        $mod = new \panix\engine\widgets\nav\Nav;
        $items = $mod->findMenu($this->id);
        return $items['items'];
    }



    public function getInfo() {
        return [
            'label' => Yii::t('stats/default', 'MODULE_NAME'),
            'author' => 'andrew.panix@gmail.com',
            'version' => '1.0',
            'icon' => 'stats',
            'description' => Yii::t('stats/default', 'MODULE_DESC'),
            'url' => ['/admin/stats'],
        ];
    }

}
