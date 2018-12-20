<?php

namespace shop\forms\manage\Shop\InfoPage;

use shop\forms\CompositeForm;
use shop\forms\manage\Shop\MetaForm;
use shop\repositories\Shop\SliderRepository;
use shop\validators\SlugValidator;
use shop\entities\Shop\InfoPage\InfoPage;
use yii\helpers\ArrayHelper;

/**
 * @property MetaForm $meta;
 */
class InfoPageForm extends CompositeForm
{
    public $name;
    public $slug;
    public $title;
    public $main_content;
    public $description;
    public $sort;
    public $sys_id;
    public $slider_name;
    public $additional_data;

    private $sliderRepository;
    private $_infoPage;

    public function __construct(SliderRepository $sliderRepository, InfoPage $infoPage = null, array $config = [])
    {
        $this->sliderRepository = $sliderRepository;

        if ($infoPage) {
            $this->name = $infoPage->name;
            $this->slug = $infoPage->slug;
            $this->title = $infoPage->title;
            $this->main_content = $infoPage->main_content;
            $this->description = $infoPage->description;
            $this->sort = $infoPage->sort;
            $this->sys_id = $infoPage->sys_id;
            $this->additional_data = $infoPage->additional_data;
            $this->meta = new MetaForm($infoPage->meta);
            $this->_infoPage = $infoPage;
        } else {
            $this->sort = InfoPage::find()->max('sort') + 1;
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }


    public function rules(): array
    {
        return [
            [['name', 'slug', 'sort'], 'required'],
            [['name', 'slug', 'title', 'main_content', 'description', 'additional_data', 'slider_name'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => InfoPage::class, 'filter' => $this->_infoPage ? ['<>', 'id', $this->_infoPage->id] : null]
        ];
    }

    public function internalForms(): array
    {
        return ['meta'];
    }

    public function getSliderNames()
    {
        return array_merge(['' => 'Please select'], ArrayHelper::map($this->sliderRepository->getSliderNames(), 'name', 'name'));
    }
}