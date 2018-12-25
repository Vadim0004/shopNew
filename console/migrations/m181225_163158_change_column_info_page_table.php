<?php

use yii\db\Migration;

/**
 * Class m181225_163158_change_column_info_page_table
 */
class m181225_163158_change_column_info_page_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%shop_info_pages}}', 'main_content', $this->text()->notNull());
        $this->alterColumn('{{%shop_info_pages}}', 'description', $this->text()->notNull());
    }

    public function down()
    {
        $this->alterColumn('{{%shop_info_pages}}', 'main_content', $this->string()->notNull());
        $this->alterColumn('{{%shop_info_pages}}', 'description', $this->string()->notNull());
    }
}
