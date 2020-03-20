<?php

namespace panix\mod\stats\migrations;

/**
 * Generation migrate by PIXELION CMS
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Class m180919_201626_stats_curf
 */

use panix\engine\db\Migration;
use panix\mod\stats\models\StatsHistory;
use panix\mod\stats\models\StatsMain;
use panix\mod\stats\models\StatsSurf;

class m180919_201626_stats extends Migration
{

    public function up()
    {
        $this->createTable(StatsSurf::tableName(), [
            'i' => $this->primaryKey(),
            'day' => $this->char(3)->null()->defaultValue(null),
            'date' => $this->date()->null()->defaultValue(null),
            'time' => $this->char(5)->null()->defaultValue(null),
            'refer' => $this->text()->null()->defaultValue(null),
            'ip' => $this->char(64)->null()->defaultValue(null),
            'proxy' => $this->char(64)->null()->defaultValue(null),
            'host' => $this->char(64)->null()->defaultValue(null),
            'lang' => $this->char(2)->null()->defaultValue(null),
            'user' => $this->text()->null()->defaultValue(null),
            'req' => $this->text()->null()->defaultValue(null),
        ], $this->tableOptions);


        $this->createTable(StatsHistory::tableName(), [
            'i' => $this->primaryKey(),
            'date' => $this->char(10)->defaultValue(null),
            'hosts' => $this->integer(11)->defaultValue(null),
            'hits' => $this->integer(11)->defaultValue(null),
            'search' => $this->integer(11)->defaultValue(null),
            'other' => $this->integer(11)->defaultValue(null),
            'fix' => $this->integer(11)->defaultValue(null)
        ], $this->tableOptions);



        $this->createTable(StatsMain::tableName(), [
            'i' => $this->primaryKey(),
            'day' => $this->char(3)->defaultValue(null),
            'date' => $this->date()->null()->defaultValue(null),
            'time' => $this->char(5)->null()->defaultValue(null),
            'refer' => $this->text()->null()->defaultValue(null),
            'ip' => $this->char(64)->null()->defaultValue(null),
            'proxy' => $this->char(64)->null()->defaultValue(null),
            'host' => $this->char(64)->null()->defaultValue(null),
            'lang' => $this->char(2)->null()->defaultValue(null),
            'user' => $this->text()->null()->defaultValue(null),
            'req' => $this->text()->null()->defaultValue(null),
        ], $this->tableOptions);


    }

    public function down()
    {
        $this->dropTable(StatsSurf::tableName());
        $this->dropTable(StatsHistory::tableName());
        $this->dropTable(StatsMain::tableName());
    }

}
