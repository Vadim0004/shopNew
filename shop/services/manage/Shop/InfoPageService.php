<?php

namespace shop\services\manage\Shop;

use shop\forms\manage\Shop\InfoPage\InfoPageStatusForm;
use shop\repositories\Shop\InfoPageRepository;
use shop\forms\manage\Shop\InfoPage\InfoPageForm;
use shop\entities\Shop\InfoPage\InfoPage;
use shop\entities\Meta;
use shop\repositories\Shop\SliderRepository;

class InfoPageService
{
    private $infoPageRepository;
    public $sliderRepository;

    public function __construct(InfoPageRepository $infoPageRepository, SliderRepository $sliderRepository)
    {
        $this->infoPageRepository = $infoPageRepository;
        $this->sliderRepository = $sliderRepository;
    }

    public function create(InfoPageForm $form): InfoPage
    {
        $infoPage = InfoPage::create(
            $form->name,
            $form->title,
            $form->slug,
            $form->main_content,
            $form->description,
            $form->sort,
            $form->additional_data,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->infoPageRepository->save($infoPage);
        return $infoPage;
    }

    public function edit(int $id, InfoPageForm $form): void
    {
        $infoPage = $this->infoPageRepository->get($id);
        $infoPage->edit(
            $form->name,
            $form->title,
            $form->slug,
            $form->main_content,
            $form->description,
            $form->sort,
            $form->additional_data,
            $form->slider_name,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->infoPageRepository->save($infoPage);
    }

    public function remove($id): void
    {
        $infoPage = $this->infoPageRepository->get($id);
        $this->infoPageRepository->remove($infoPage);
    }

    public function activate(int $id): void
    {
        $infoPage = $this->infoPageRepository->get($id);
        $infoPage->activate();
        $this->infoPageRepository->save($infoPage);
    }

    public function draft(int $id): void
    {
        $infoPage = $this->infoPageRepository->get($id);
        $infoPage->draft();
        $this->infoPageRepository->save($infoPage);
    }

    public function changeStatusSysId($id, InfoPageStatusForm $form): void
    {
        $infoPage = $this->infoPageRepository->get($id);
        $infoPage->changeStatus($form->sysId);
        $this->infoPageRepository->save($infoPage);
    }
}