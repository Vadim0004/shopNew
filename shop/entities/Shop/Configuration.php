<?php

namespace shop\entities\Shop;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "shop_configurations".
 *
 * @property int $id
 * @property string $configuration_title
 * @property string $configuration_key
 * @property string $configuration_value
 * @property string $configuration_description
 * @property string $created_at
 */
class Configuration extends ActiveRecord
{
    /**
     * @param string $configurationTitle
     * @param string $configurationKey
     * @param string $configurationValue
     * @param string $configurationDescription
     * @return Configuration
     */
    public static function create(string $configurationTitle, string $configurationKey, $configurationValue, $configurationDescription): self
    {
        $configuration = new static();
        $configuration->configuration_title = $configurationTitle;
        $configuration->configuration_key = $configurationKey;
        $configuration->configuration_value = $configurationValue;
        $configuration->configuration_description = $configurationDescription;
        $configuration->created_at = time();
        return $configuration;
    }

    /**
     * @param $configurationValue
     * @param $configurationDescription
     */
    public function edit($configurationValue, $configurationDescription): void
    {
        $this->configuration_value = $configurationValue;
        $this->configuration_description = $configurationDescription;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{shop_configurations}}';
    }
}
