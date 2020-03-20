<?php

namespace panix\mod\stats\models;

use panix\engine\db\ActiveRecord;

class StatsSurf extends ActiveRecord {

    const MODULE_ID = 'stats';


    /**
     * @return string the associated database table name
     */
    public static function tableName() {
        return '{{%stats__surf}}';
    }

    /*
      public function getIpAdress(){
      $text='';
      if ($this->ip != "unknown")
      $text .= Html::link($this->ip,'?item=ip&qs=' . $this->ip,array('target'=>'_blank'));
      else
      $text .= "<font color=grey>неизвестно</font>";
      if ($this->proxy != ""){
      $text .= '<br>';
      $text .= Html::link('через proxy','?item=ip&qs=' . $this->proxy,array('target'=>'_blank'));

      }
      return $text;
      } */

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            //array('day, dt, tm, refer, ip, proxy, host, lang, user, req', 'type', 'type' => 'string'),
            array('refer, user, req', 'required'),
            array('proxy, host, ip', 'length', 'min' => 64),
            array('day', 'length', 'min' => 3),
            array('date', 'length', 'min' => 8),
            array('time', 'length', 'min' => 5),
            array('lang', 'length', 'min' => 2),
                //array('title, slug', 'required'),
                // array('category_id', 'numerical', 'integerOnly' => true),
                // array('date_create, date_update', 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'),
                // array('title, slug, seo_title, seo_description, seo_keywords', 'length', 'max' => 255),
                //array('id, user_id, category_id, title, slug, short_text, full_text, seo_title, seo_description, seo_keywords, date_update, date_create', 'safe', 'on' => 'search'),
        );
    }


}
