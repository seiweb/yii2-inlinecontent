<?php

use yii\db\Migration;

class m170225_193855_main_page extends Migration
{
    public function up()
    {
        $this->addColumn('{{%nested_page}}', 'is_main', $this->integer()->defaultValue(0)->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%nested_page}}', 'is_main');
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
