<?php

use yii\db\Schema;
use yii\db\Migration;

class m150825_130751_createUser extends Migration
{
    public function up()
    {

        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'userId' => $this->smallInteger(),
            'firstName' => $this->string()->notNull(),
            'lastName' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'address' => $this->text()->notNull(),
            'skypeId' => $this->smallInteger(),
            'profilePicture' => $this->string()
        ] );

    }

    public function down()
    {
        $this->dropTable('users');
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
