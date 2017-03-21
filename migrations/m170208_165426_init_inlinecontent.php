<?php

use yii\db\Migration;

class m170208_165426_init_inlinecontent extends Migration
{
	public function up()
	{
		$this->createTable('{{%nested_page_section}}', [
			'id' => $this->primaryKey(),
			//'tree' => $this->integer()->notNull(),
			'page_id' => $this->integer()->notNull(),
			'module' => $this->string()->notNull(),
			'sort_order' => $this->integer()->notNull(),
			'status' => $this->integer()->notNull()->defaultValue(1),
			'options' => $this->text(),
		]);

		$this->insert('{{%nested_page_section}}',[
			'page_id'=>2,
			'module'=>'wysiwyg',
			'sort_order'=>0,
			'status'=>1
		]);

		$this->createTable('{{%nested_page_wysiwig}}', [
			'section_id' => $this->integer()->notNull()->append('PRIMARY KEY'),
			'content' => $this->text()->notNull(),
		]);

		$this->insert('{{%nested_page_wysiwig}}',[
			'section_id'=>1,
			'content'=>'<p>Hello! It WYSIWIG module!</p>'
		]);

/*
		$this->createIndex('{{%user_unique_username}}', '{{%user}}', 'username', true);
		$this->createIndex('{{%user_unique_email}}', '{{%user}}', 'email', true);
		$this->createIndex('{{%user_confirmation}}', '{{%user}}', 'id, confirmation_token', true);
		$this->createIndex('{{%user_recovery}}', '{{%user}}', 'id, recovery_token', true);

		$this->createTable('{{%profile}}', [
			'user_id' => $this->integer()->notNull()->append('PRIMARY KEY'),
			'name' => $this->string(255)->null(),
			'public_email' => $this->string(255)->null(),
			'gravatar_email' => $this->string(255)->null(),
			'gravatar_id' => $this->string(32)->null(),
			'location' => $this->string(255)->null(),
			'website' => $this->string(255)->null(),
			'bio' => $this->text()->null(),
		], $this->tableOptions);

		$this->addForeignKey('{{%fk_user_profile}}', '{{%profile}}', 'user_id', '{{%user}}', 'id', $this->cascade, $this->restrict);*/
	}

	public function down()
	{
		echo "m170208_165426_init cannot be reverted.\n";
		$this->dropTable('{{%nested_page_section}}');
		$this->dropTable('{{%nested_page_wysiwig}}');
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
