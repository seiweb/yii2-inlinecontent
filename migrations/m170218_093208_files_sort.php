<?php

use yii\db\Migration;

class m170218_093208_files_sort extends Migration
{
    public function up()
    {
        $this->addColumn('{{%nested_page_files}}', 'sort_order', $this->integer()->notNull());
    }

    public function down()
    {
        echo "m170218_093208_files_sort cannot be reverted.\n";
        $this->dropColumn('{{%nested_page_files}}', 'sort_order');

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
