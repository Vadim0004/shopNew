<?php

namespace shop\forms\manage\Shop;

use yii\base\Model;
use yii\web\UploadedFile;
use shop\entities\Shop\Slider;

class SliderForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $files;
    public $name;
    public $comment;

    private $_slider;

    public function __construct(Slider $slider = null, array $config = [])
    {
        if ($slider) {
            $this->name = $slider->name;
            $this->comment = $slider->comment;
        }
        $this->_slider = $slider;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'comment'], 'required'],
            [['name', 'comment'], 'string', 'max' => 255],
            [['name', 'comment'], 'unique', 'targetClass' => Slider::class, 'filter' => $this->_slider ? ['<>', 'id', $this->_slider->id] : null],
            ['files', 'each', 'rule' => ['image']],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->files = UploadedFile::getInstances($this, 'files'); // $_FILES
            return true;
        }
        return false;
    }
}