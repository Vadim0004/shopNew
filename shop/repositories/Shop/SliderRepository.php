<?php

namespace shop\repositories\Shop;

use shop\entities\Shop\Slider;

class SliderRepository
{
    public function get($id): Slider
    {
        if (!$slider = Slider::findOne($id)) {
            throw new NotFoundException('Slider is not found.');
        }
        return $slider;
    }

    public function save(Slider $slider): void
    {
        if (!$slider->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Slider $slider): void
    {
        if (!$slider->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSliderNames()
    {
        $sliderName = Slider::find()->select('name')->distinct()->all();
        return $sliderName;
    }
}