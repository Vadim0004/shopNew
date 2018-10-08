<?php

use yii\db\Migration;

/**
 * Class m181008_082948_rename_user_table
 */
class m181008_082948_rename_user_table extends Migration
{
    public function up()
    {
        $this->renameTable('{{%user}}', '{{%users}}');
    }
    public function down()
    {
        $this->renameTable('{{%users}}', '{{%user}}');
    }
}
