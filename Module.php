<?php

namespace panix\mod\stats;

use Yii;
use panix\engine\Html;
use panix\engine\WebModule;

class Module extends WebModule {

    public $icon = 'stats';

    public function getAdminMenu() {
        $c =Yii::$app->controller->id;
        $a =Yii::$app->controller->action->id;
        return [
            'modules' => [
                'items' => [
                    [
                        'label' => Yii::t('stats/default', 'MODULE_NAME'),
                        //'url' => ['/admin/stats'],
                        'icon' => $this->icon,
                        'items' => [
                            [
                                'label' => 'dsa',
                                'url' => ['/admin/stats'],
                                'icon' => Html::icon('icon-stats')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'BROWSERS'),
                                'url' => ['/admin/stats/browsers'],
                                'active' => ($c == 'admin/browsers') ? true : false,
                                'icon' => Html::icon('icon-firefox')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'TIMEVISIT'),
                                'url' => ['/admin/stats/timevisit'],
                                'active' => ($c == 'admin/timevisit') ? true : false,
                                'icon' => Html::icon('icon-time')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'PAGEVISIT'),
                                'url' => ['/admin/stats/pagevisit'],
                                'active' => ($c == 'admin/pagevisit') ? true : false,
                                'icon' => Html::icon('icon-monitor-stats')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'ROBOTS'),
                                'url' => ['/admin/stats/robots'],
                                'active' => ($c == 'admin/robots') ? true : false,
                                'icon' => Html::icon('icon-android')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'REF_DOMAIN'),
                                'url' => ['/admin/stats/refdomain'],
                                'active' => ($c == 'admin/refdomain') ? true : false,
                                'icon' => Html::icon('icon-http')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'IP_ADDRESS'),
                                'url' => ['/admin/stats/ipaddress'],
                                'active' => ($c == 'admin/ipaddress') ? true : false,
                                'icon' => Html::icon('icon-ip')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'Поисковые запросы'),
                                'url' => ['/admin/stats/searchquery'],
                                'active' => ($c == 'admin/searchquery' && $a == 'index') ? true : false,
                                'icon' => Html::icon('icon-search')
                            ],
                            [
                                'label' => Yii::t('stats/default', 'Поисковые системы'),
                                'url' => ['/admin/stats/searchquery/system'],
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
        $mod = new \panix\engine\bootstrap\Nav;
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
