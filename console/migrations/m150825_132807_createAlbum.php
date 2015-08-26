<?php

use yii\db\Schema;
use yii\db\Migration;

class m150825_132807_createAlbum extends Migration
{
    public function up()
    {
        $this->createTable('album', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'tag' => $this->string()->notNull(),
        ] );

    }
    public function down()
    {
      $this->dropTable('album');
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
