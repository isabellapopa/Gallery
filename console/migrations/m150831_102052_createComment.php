<?php

use yii\db\Schema;
use yii\db\Migration;

class m150831_102052_createComment extends Migration
{
    public function up()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'photoId' => $this->smallInteger()->notNull(),
            'userId' => $this ->smallInteger()->notNull(),
            'commentText' => $this->string()->notNull(),
        ] );
    }

    public function down()
    {
       $this->dropTable('comment');
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
