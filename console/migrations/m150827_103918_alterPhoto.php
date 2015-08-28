<?php

use yii\db\Schema;
use yii\db\Migration;

class m150827_103918_alterPhoto extends Migration
{
    public function up()
    {
    return ;
    }

    public function down()
    {
        $this->dropColumn('photo','userId');
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
