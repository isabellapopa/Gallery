<?php

use yii\db\Schema;
use yii\db\Migration;

class m150827_100325_alterAlbum extends Migration
{
    public function up()
    {
        $this->addColumn('album', 'numberPhotos',Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('album','numberPhotos');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
