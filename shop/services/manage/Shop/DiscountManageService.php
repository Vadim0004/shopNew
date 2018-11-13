<?php

namespace shop\services\manage\Shop;


use shop\entities\Shop\Discount;
use shop\forms\manage\Shop\DiscountForm;
use shop\repositories\Shop\DiscountRepository;

class DiscountManageService
{
    public $discountRepository;

    public function __construct(DiscountRepository $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }

    public function create(DiscountForm $form): Discount
    {
        $discount = Discount::create(
            $form->percent,
            $form->name,
            $form->from_date,
            $form->to_date,
            $form->sort
        );
        $this->discountRepository->save($discount);
        return $discount;
    }

    public function edit($id, DiscountForm $form): void
    {
        $discount = $this->discountRepository->get($id);
        $discount->edit(
            $form->percent,
            $form->name,
            $form->from_date,
            $form->to_date,
            $form->sort,
            $form->active
        );
        $this->discountRepository->save($discount);
    }

    public function remove($id): void
    {
        $discount = $this->discountRepository->get($id);
        $this->discountRepository->remove($discount);
    }
}