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

    public function edite()
    {

    }
}