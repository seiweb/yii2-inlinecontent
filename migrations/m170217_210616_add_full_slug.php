<?php

use yii\db\Migration;

class m170217_210616_add_full_slug extends Migration
{
    public function up()
    {
        $tableName = '{{%nested_page}}';
        $this->addColumn($tableName, 'full_slug', $this->text());
    }

    public function down()
    {
        $tableName = '{{%nested_page}}';
        $this->dropColumn($tableName, 'full_slug');
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
