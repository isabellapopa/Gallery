<?php

use yii\db\Schema;
use yii\db\Migration;

class m150826_080326_createCont extends Migration
{
    public function up()
    {
        $this->createTable('account', [
            'id' => $this->primaryKey(),
            'accountType' => $this->string()->notNull(),
            'userId' => $this->smallInteger()->notNull(),
            'cardName' => $this-> string() ->notNull(),
            'activeAccount' => $this->smallInteger(),
        ] );

    }

    public function down()
    {
       $this->dropTable('cont');
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
