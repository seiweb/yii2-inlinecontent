<?php

use yii\db\Migration;

class m170225_193856_add_block extends Migration
{
    public function up()
    {
        $this->addColumn('{{%nested_page_section}}', 'block', $this->string()->defaultValue('content')->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%nested_page_section}}', 'block');
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
