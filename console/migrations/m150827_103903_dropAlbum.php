<?php

use yii\db\Schema;
use yii\db\Migration;

class m150827_103903_dropAlbum extends Migration
{
    public function up()
    {
        $this->addColumn('album', 'userId',Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('album','userId');
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
