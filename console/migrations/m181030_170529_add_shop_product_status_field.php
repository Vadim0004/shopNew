<?php

use yii\db\Migration;

/**
 * Class m181030_170529_add_shop_product_status_field
 */
class m181030_170529_add_shop_product_status_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%shop_products}}', 'status', $this->smallInteger()->notNull());
        $this->update('{{%shop_products}}', ['status' => 1]);
    }
    public function down()
    {
        $this->dropColumn('{{%shop_products}}', 'status');
    }
}
