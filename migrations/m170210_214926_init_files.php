<?php

use yii\db\Migration;

class m170210_214926_init_files extends Migration
{
	public function up()
	{
		$this->createTable('{{%nested_page_files}}', [
			'id' => $this->primaryKey(),
			'section_id' => $this->integer()->notNull(),
			'friendly_name' => $this->string(255)->notNull(),
			'file_name' => $this->string(255)->notNull(),
			'mime' => $this->string(255)->notNull(),
			'size'=>$this->integer(11)->notNull(),
			'ext'=>$this->string(6)->notNull(),
			'created_at'=>$this->dateTime()->notNull(),
			'updated_at'=>$this->dateTime()->notNull(),
		]);
	}

	public function down()
	{
		$this->dropTable('{{%nested_page_files}}');
	}

	/*
	// Use safeUp/safeDown to run migration code within a transaction
	public function safeUp()
	}

	public function safeDown()
	{
	}
	*/
}
