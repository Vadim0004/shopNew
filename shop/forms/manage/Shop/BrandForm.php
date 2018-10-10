<?php

namespace shop\forms\manage\Shop;

use yii\base\Model;
use shop\validators\SlugValidator;
use shop\entities\Shop\Brand;
use yii\helpers\ArrayHelper;

class BrandForm extends Model
{
    public $name;
    public $slug;
    public $meta;

    private $_brand;

    public function __construct(Brand $brand = null, $config = [])
    {
        if ($brand) {
            $this->name = $brand->name;
            $this->slug = $brand->slug;
            $this->meta = new MetaForm($brand->meta);
            $this->_brand = $brand;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function load($data, $formName = null)
    {
        $self = parent::load($data, $formName);
        $meta = $this->meta->load($data, $formName === '' ? 'meta' : null);
        return $self && $meta;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $self = parent::validate($attributeNames, $clearErrors);
        $meta = $this->meta->validate(ArrayHelper::getValue($attributeNames, 'meta'), $clearErrors);
        return $self && $meta;
    }

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : null]
        ];
    }
}