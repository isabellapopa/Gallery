<?php

use yii\db\Schema;
use yii\db\Migration;

class m150827_142802_createAccount extends Migration
{
    public function up()
    {
        $this->createTable('account', [
            'id' => $this->primaryKey(),
            'userId' => $this->smallInteger(),
            'cardType' => $this->string()->notNull(),
            'accountType' => $this->string(),
            'monthAccountDisable' => $this->smallInteger()->notNull(),
            'yearAccountDisable' => $this->string()->defaultValue("2015")
        ] );

    }

    public function down()
    {
       $this->dropTable('account');
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
