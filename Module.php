<?php
namespace panix\mod\stats;

class Module extends \panix\engine\WebModule{

    public function init2() {

        // parent::init();
        /*
         * Баг, при ошибки на сайте, показывается админская ошибка!
         * Yii::$app->setComponents(array(
          'errorHandler' => array(
          'errorAction' => 'site/errorAdmin',
          ),
          )); */


    }



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
        $c = Yii::$app->controller->module->id;
        return array(
            'modules' => array(
                'items' => array(
                    array(
                        'label' => Yii::t('stats/default', 'MODULE_NAME'),
                        'url' => $this->adminHomeUrl,
                        'active' => ($c == 'stats') ? true : false,
                        'icon' => Html::icon($this->icon),
                        'visible' => Yii::$app->user->isSuperuser
                    ),
                ),
            ),
        );
    }

    public function getAdminSidebarMenu() {
        $c = Yii::$app->controller->id;
        $a = Yii::$app->controller->action->id;
        return array(
            array(
                'label' => $this->name,
                'url' => $this->adminHomeUrl,
                'active' => ($c == 'admin/default') ? true : false,
                'icon' => Html::icon('icon-stats')
            ),
            array(
                'label' => Yii::t('stats/default', 'BROWSERS'),
                'url' => array('/admin/stats/browsers'),
                'active' => ($c == 'admin/browsers') ? true : false,
                'icon' => Html::icon('icon-firefox')
            ),
            array(
                'label' => Yii::t('stats/default', 'TIMEVISIT'),
                'url' => array('/admin/stats/timevisit'),
                'active' => ($c == 'admin/timevisit') ? true : false,
                'icon' => Html::icon('icon-time')
            ),
            array(
                'label' => Yii::t('stats/default', 'PAGEVISIT'),
                'url' => array('/admin/stats/pagevisit'),
                'active' => ($c == 'admin/pagevisit') ? true : false,
                'icon' => Html::icon('icon-monitor-stats')
            ),
            array(
                'label' => Yii::t('stats/default', 'ROBOTS'),
                'url' => array('/admin/stats/robots'),
                'active' => ($c == 'admin/robots') ? true : false,
                'icon' => Html::icon('icon-android')
            ),
            array(
                'label' => Yii::t('stats/default', 'REF_DOMAIN'),
                'url' => array('/admin/stats/refdomain'),
                'active' => ($c == 'admin/refdomain') ? true : false,
                'icon' => Html::icon('icon-http')
            ),
            array(
                'label' => Yii::t('stats/default', 'IP_ADDRESS'),
                'url' => array('/admin/stats/ipaddress'),
                'active' => ($c == 'admin/ipaddress') ? true : false,
                'icon' => Html::icon('icon-ip')
            ),
            array(
                'label' => Yii::t('stats/default', 'Поисковые запросы'),
                'url' => array('/admin/stats/searchquery'),
                'active' => ($c == 'admin/searchquery' && $a == 'index') ? true : false,
                'icon' => Html::icon('icon-search')
            ),
            array(
                'label' => Yii::t('stats/default', 'Поисковые системы'),
                'url' => array('/admin/stats/searchquery/system'),
                'active' => ($c == 'admin/searchquery' && $a == 'system') ? true : false,
                'icon' => Html::icon('icon-search')
            ),
        );
    }

}
