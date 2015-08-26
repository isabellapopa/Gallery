<?php

use yii\db\Schema;
use yii\db\Migration;

class m150825_132817_createPhoto extends Migration
{
    public function up()
    {
        $this->createTable('photo', [
            'id' => $this->primaryKey(),
            'albumId' => $this->smallInteger()->notNull(),
            'userId' => $this ->smallInteger()->notNull(),
            'photoName' => $this-> string() ->notNull(),
            'description' => $this->text()->notNull(),
            'tag' => $this->string()->notNull(),
        ] );
    }

    public function down()
    {
       $this->dropTable('photo');
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
