<?php

use yii\db\Migration;

/**
 * Class m190110_094429_insert_np_to_configuration
 */
class m190110_094429_insert_np_to_configuration extends Migration
{
    public function up()
    {
        $this->insert('{{%shop_configurations}}', [
            'configuration_title' => 'Nova Poshta',
            'configuration_key' => 'MODULE_SHIPPING_NP_APIKEY',
            'configuration_value' => '',
            'configuration_description' => 'Nova Poshta shipping method',
            'created_at' => time(),
        ]);
    }

    public function down()
    {
        $this->delete('{{%shop_configurations}}', ['configuration_key' => 'MODULE_SHIPPING_NP_APIKEY']);
    }
}
