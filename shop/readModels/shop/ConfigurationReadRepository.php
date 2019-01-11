<?php

namespace shop\readModels\shop;

use shop\entities\Shop\Configuration;

class ConfigurationReadRepository
{
    public function getConfigurationValue($configurationKey): ?Configuration
    {
        $configuration = Configuration::find()->where(['configuration_key' => $configurationKey])->one();
        return $configuration;
    }
}