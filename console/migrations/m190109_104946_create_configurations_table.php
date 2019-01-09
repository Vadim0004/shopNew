<?php

use yii\db\Migration;

/**
 * Handles the creation of table `configurations`.
 */
class m190109_104946_create_configurations_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%shop_configurations}}', [
            'id' => $this->primaryKey(),
            'configuration_title' => $this->string(64)->notNull(),
            'configuration_key' => $this->string(64)->notNull(),
            'configuration_value' => $this->text(),
            'configuration_description' => $this->string(255),
            'created_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shop_configurations-key}}', '{{%shop_configurations}}', 'configuration_key', true);
    }

    public function down()
    {
        $this->dropTable('{{%shop_configurations}}');
    }
}
