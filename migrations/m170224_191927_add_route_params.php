<?php

use yii\db\Migration;

class m170224_191927_add_route_params extends Migration
{
    public function up()
    {
        $this->addColumn('{{%nested_page}}', 'route_params', $this->string(255)->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%nested_page}}','route_paramd');
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
