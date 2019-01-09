<?php

namespace shop\forms\manage\Shop;

use shop\entities\Shop\Configuration;
use yii\base\Model;

class ConfigurationForm extends Model
{
    public $configuration_title;
    public $configuration_key;
    public $configuration_value;
    public $configuration_description;

    private $_configuration;

    public function __construct(Configuration $configuration = null, array $config = [])
    {
        if ($configuration) {
            $this->configuration_title = $configuration->configuration_title;
            $this->configuration_key = $configuration->configuration_key;
            $this->configuration_value = $configuration->configuration_value;
            $this->configuration_description = $configuration->configuration_description;
            $this->_configuration = $configuration;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['configuration_title', 'configuration_key'], 'required'],
            [['configuration_title', 'configuration_key'], 'string', 'max' => 64],
            [['configuration_description'], 'string', 'max' => 255],
            [['configuration_title', 'configuration_key'], 'unique', 'targetClass' => Configuration::class, 'filter' => $this->_configuration ? ['<>', 'id', $this->_configuration->id] : null]
        ];
    }
}