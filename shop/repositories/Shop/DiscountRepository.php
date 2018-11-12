<?php

namespace shop\repositories\Shop;

use shop\entities\Shop\Discount;
use shop\repositories\NotFoundException;

class DiscountRepository
{
    public function get($id): Discount
    {
        if (!$discount = Discount::findOne($id)) {
            throw new NotFoundException('Discount is not found.');
        }
        return $discount;
    }

    public function findByName($name): ?Discount
    {
        return Discount::findOne(['name' => $name]);
    }

    public function save(Discount $discount): void
    {
        if (!$discount->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Discount $discount): void
    {
        if (!$discount->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}