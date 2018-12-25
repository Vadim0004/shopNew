<?php

namespace shop\services\manage\Shop;

use shop\entities\Shop\Slider;
use shop\forms\manage\Shop\SliderForm;
use shop\repositories\Shop\InfoPageRepository;
use shop\repositories\Shop\SliderRepository;
use shop\forms\manage\Shop\Product\PhotosForm;

class SliderManageService
{
    private $sliderRepository;
    private $infoPageRepository;

    public function __construct(SliderRepository $sliderRepository, InfoPageRepository $infoPageRepository)
    {
        $this->sliderRepository = $sliderRepository;
        $this->infoPageRepository = $infoPageRepository;
    }

    public function create(SliderForm $form): Slider
    {
        $slider = Slider::create(
            $form->name,
            $form->comment
        );

        if ($form->files) {
            foreach ($form->files as $file) {
                $slider->setPhoto($file);
            }
        } else {
            $slider->setPhotoEmpty();
        }

        $this->sliderRepository->save($slider);
        return $slider;
    }

    public function edit($id, SliderForm $form): void
    {
        $slider = $this->sliderRepository->get($id);
        $slider->edit($form->name, $form->comment);
        $this->sliderRepository->save($slider);
    }

    public function addPhoto($id, PhotosForm $form): void
    {
        $slider = $this->sliderRepository->get($id);
        foreach ($form->files as $file) {
            $slider->addPhoto($file);
        }
        $this->sliderRepository->save($slider);
    }

    public function remove($id): void
    {
        $slider = $this->sliderRepository->get($id);
        $sliderToInfoPage = $this->infoPageRepository->getSliderToInfoPage($slider->name);
        if (!$sliderToInfoPage) {
            $this->sliderRepository->remove($slider);
        }
    }
}