<?php

use yii\db\Migration;

/**
 * Class m181218_140737_create_info_pages_tables
 */
class m181218_140737_create_info_pages_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%shop_info_pages}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'main_content' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
            'sys_id' => $this->integer()->notNull(),
            'sys_statuses_json' => 'JSON NOT NULL',
            'slider_name' => $this->string(),
            'additional_data' => $this->string()->notNull(),
            'meta_json' => 'JSON NOT NULL',
            'created_at' => $this->integer()->unsigned()->notNull(),
            'update_at' => $this->integer()->unsigned(),
            'status' => $this->smallInteger()->notNull(),

        ], $tableOptions);

        $this->createIndex('{{%idx-shop_info_pages-name}}', '{{%shop_info_pages}}', 'name', true);

        $this->addForeignKey('{{%fk-shop_info_pages-slider_name}}', '{{%shop_info_pages}}', 'slider_name', '{{%shop_sliders}}', 'name');
    }

    public function down()
    {
        $this->dropTable('{{%shop_products}}');
    }
}
