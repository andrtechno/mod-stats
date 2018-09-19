<?php
/**
 * Generation migrate by PIXELION CMS
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Class m180919_201626_stats_curf
 */

use yii\db\Schema;
use panix\engine\db\Migration;
use panix\mod\stats\models\StatsSurf;

class m180919_201626_stats_curf extends Migration {

    public function up()
    {
        $this->createTable(StatsSurf::tableName(), [
            'i' => $this->primaryKey(),
            'day' => $this->char(3)->null()->defaultValue(null),
            'dt' => $this->date()->null()->defaultValue(null),
            'tm' => $this->char(5)->null()->defaultValue(null),
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
    }

}
