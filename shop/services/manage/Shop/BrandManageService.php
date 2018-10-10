<?php

namespace shop\services\manage\Shop;

use shop\forms\manage\Shop\BrandForm;
use shop\entities\Shop\Brand;
use shop\repositories\Shop\BrandRepository;
use shop\entities\Meta;

class BrandManageService
{
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function create(BrandForm $form): Brand
    {
        $brand = Brand::create(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->brandRepository->save($brand);
        return $brand;
    }

    public function edit($id, BrandForm $form): void
    {
        $brand = $this->brandRepository->get($id);
        $brand->edit(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->brandRepository->save($brand);
    }

    public function remove($id): void
    {
        $tag = $this->brandRepository->get($id);
        $this->brandRepository->remove($tag);
    }
}