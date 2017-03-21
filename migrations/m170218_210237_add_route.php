<?php

use yii\db\Migration;

class m170218_210237_add_route extends Migration
{
    public function up()
    {
        $this->addColumn('{{%nested_page}}', 'route', $this->string(255)->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%nested_page}}','route');
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
