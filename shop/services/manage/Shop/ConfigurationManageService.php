<?php

namespace shop\services\manage\Shop;

use shop\repositories\Shop\ConfigurationRepository;
use shop\forms\manage\Shop\ConfigurationForm;
use shop\entities\Shop\Configuration;

class ConfigurationManageService
{
    private $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    public function create(ConfigurationForm $form): Configuration
    {
        $configuration = Configuration::create(
            $form->configuration_title,
            $form->configuration_key,
            $form->configuration_value,
            $form->configuration_description
        );
        $this->configurationRepository->save($configuration);
        return $configuration;
    }

    public function edit(int $id, ConfigurationForm $form): void
    {
        $configuration = $this->configurationRepository->get($id);
        $configuration->edit(
            $form->configuration_value,
            $form->configuration_description
        );
        $this->configurationRepository->save($configuration);
    }
}