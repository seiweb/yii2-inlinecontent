<?php

use yii\db\Migration;

class m170217_203831_update_fields extends Migration
{
    public function up()
    {
        $tableName = '{{%nested_page}}';
        $this->renameColumn($tableName, 'name', 'title');
        $this->renameColumn($tableName, 'alias', 'slug');
        $this->renameColumn($tableName, 'created_by', 'modified_by');
        $this->dropColumn($tableName,'updated_by');
    }

    public function down()
    {
        $tableName = '{{%nested_page}}';
        echo "m170217_203831_update_fields cannot be reverted.\n";
        $this->renameColumn($tableName, 'title', 'name');
        $this->renameColumn($tableName, 'slug', 'alias');
        $this->renameColumn($tableName, 'modified_by', 'created_by');
        $this->addColumn($tableName,'updated_by',$this->string()->notNull());
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
