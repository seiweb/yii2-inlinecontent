<?php

use yii\db\Migration;

class m170217_193530_update_fields extends Migration
{
    public function up()
    {
        $this->addColumn('{{%nested_page_section}}', 'created_at', $this->dateTime()->notNull());
        $this->addColumn('{{%nested_page_section}}', 'updated_at', $this->dateTime()->notNull());
        $this->addColumn('{{%nested_page_section}}', 'modified_by', $this->string(255)->notNull()->defaultValue(''));
    }

    public function down()
    {
        $this->dropColumn('{{%nested_page_section}}', 'created_at');
        $this->dropColumn('{{%nested_page_section}}', 'updated_at');
        $this->dropColumn('{{%nested_page_section}}', 'modified_by');
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
