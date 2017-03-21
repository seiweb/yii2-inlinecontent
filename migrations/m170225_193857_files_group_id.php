<?php

use yii\db\Migration;

class m170225_193857_files_group_id extends Migration
{
    public function up()
    {
        $this->addColumn('{{%nested_page_files}}', 'group_id', $this->integer()->defaultValue(1)->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%nested_page_files}}', 'group_id');
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
