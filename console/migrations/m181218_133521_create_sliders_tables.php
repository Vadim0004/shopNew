<?php

use yii\db\Migration;

/**
 * Class m181218_133521_create_sliders_tables
 */
class m181218_133521_create_sliders_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%shop_sliders}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'file' => $this->string()->notNull(),
            'comment' => $this->string(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shop_sliders-name}}', '{{%shop_sliders}}', 'name', true);
    }

    public function down()
    {
        $this->dropTable('{{%shop_products}}');
    }
}
