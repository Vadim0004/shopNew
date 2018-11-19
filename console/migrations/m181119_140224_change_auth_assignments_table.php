<?php

use yii\db\Migration;

/**
 * Class m181119_140224_change_auth_assignments_table
 */
class m181119_140224_change_auth_assignments_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%auth_assignments}}', 'user_id', $this->integer()->notNull());
        $this->createIndex('{{%idx-auth_assignments-user_id}}', '{{%auth_assignments}}', 'user_id');
        $this->addForeignKey('{{%fk-auth_assignments-user_id}}', '{{%auth_assignments}}', 'user_id', '{{%users}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('{{%fk-auth_assignments-user_id}}', '{{%auth_assignments}}');
        $this->dropIndex('{{%idx-auth_assignments-user_id}}', '{{%auth_assignments}}');
        $this->alterColumn('{{%auth_assignments}}', 'user_id', $this->string(64)->notNull());
    }
}
