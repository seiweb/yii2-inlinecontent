<?php

use yii\db\Migration;

class m170209_084709_init_nestedpage extends Migration
{
    private $_tableName = '{{%nested_page}}';

    public function up()
    {
        $this->createTable($this->_tableName, [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'alias' => $this->string()->notNull(),
            'html'=>$this->text(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->string()->notNull(),
            'updated_by' => $this->string()->notNull(),

        ]);

        $this->insert($this->_tableName,[
            'lft'=>1,
            'rgt'=>2,
            'depth'=>0,
            'name'=>'root',
            'alias'=>'root',
            'html'=>'',
            'created_at'=> new \yii\db\Expression('NOW()'),
            'updated_at'=> new \yii\db\Expression('NOW()'),
            'created_by'=> 'migrate',
            'updated_by'=> 'migrate'
        ]);

    }

    public function down()
    {
        echo "m170209_084709_init cannot be reverted.\n";
        $this->dropTable($this->_tableName);
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
