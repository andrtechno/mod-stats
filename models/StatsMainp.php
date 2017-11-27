<?php
namespace panix\mod\stats\models;


class StatsMainp extends \panix\engine\db\ActiveRecord {

    const MODULE_ID = 'stats';



    /**
     * @return string the associated database table name
     */
    public static function tableName() {
        return '{{%mainp}}';
    }



    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            //array('day, dt, tm, refer, ip, proxy, host, lang, user, req', 'type', 'type' => 'string'),
            array('refer, user, req', 'required'),
            array('proxy, host, ip', 'length', 'min' => 64),
            array('day', 'length', 'min' => 3),
            array('dt', 'length', 'min' => 8),
            array('tm', 'length', 'min' => 5),
            array('lang', 'length', 'min' => 2),
            //array('title, seo_alias', 'required'),
           // array('category_id', 'numerical', 'integerOnly' => true),
           // array('date_create, date_update', 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'),
           // array('title, seo_alias, seo_title, seo_description, seo_keywords', 'length', 'max' => 255),
            //array('id, user_id, category_id, title, seo_alias, short_text, full_text, seo_title, seo_description, seo_keywords, date_update, date_create', 'safe', 'on' => 'search'),
        );
    }


}
