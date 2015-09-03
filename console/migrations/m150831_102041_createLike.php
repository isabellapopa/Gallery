<?php

use yii\db\Schema;
use yii\db\Migration;

class m150831_102041_createLike extends Migration
{
    public function up()
    {
        $this->createTable('like', [
            'id' => $this->primaryKey(),
            'photoId' => $this->smallInteger()->notNull(),
            'userId' => $this ->smallInteger()->notNull(),
            'likePhoto' => $this->string(),
        ] );

    }

    public function down()
    {
       $this->dropTable('like');

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
