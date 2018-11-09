<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_discounts`.
 */
class m181109_084737_create_shop_discounts_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%shop_discounts}}', [
            'id' => $this->primaryKey(),
            'percent' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'from_date' => $this->date(),
            'to_date' => $this->date(),
            'active' => $this->boolean()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);
    }
    public function down()
    {
        $this->dropTable('{{%shop_discounts}}');
    }
}
