<?php

namespace shop\repositories\Shop;

use shop\entities\Shop\Configuration;
use shop\repositories\NotFoundException;

class ConfigurationRepository
{
    public function get($id): Configuration
    {
        if (!$configuration = Configuration::findOne($id)) {
            throw new NotFoundException('Configuration is not found.');
        }
        return $configuration;
    }

    public function save(Configuration $configuration): void
    {
        if (!$configuration->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Configuration $configuration): void
    {
        if (!$configuration->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}