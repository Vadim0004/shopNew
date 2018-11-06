<?php

use yii\db\Migration;

/**
 * Class m181103_074734_add_shop_product_is_featured_field
 */
class m181103_074734_add_shop_product_is_featured_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%shop_products}}', 'is_featured', $this->smallInteger()->notNull());
        $this->update('{{%shop_products}}', ['is_featured' => 0]);
    }
    public function down()
    {
        $this->dropColumn('{{%shop_products}}', 'is_featured');
    }
}
