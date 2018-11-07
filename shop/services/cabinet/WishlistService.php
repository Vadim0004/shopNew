<?php

namespace shop\services\cabinet;

use shop\repositories\Shop\ProductRepository;
use shop\repositories\UserRepository;

class WishlistService
{
    private $user;
    private $products;

    public function __construct(UserRepository $user, ProductRepository $products)
    {
        $this->user = $user;
        $this->products = $products;
    }

    public function add(int $userId, int $productId): void
    {
        $user = $this->user->get($userId);
        $product = $this->products->get($productId);
        $user->addToWishList($product->id);
        $this->user->save($user);
    }

    public function remove(int $userId, int $productId): void
    {
        $user = $this->user->get($userId);
        $product = $this->products->get($productId);
        $user->removeFromWishList($product->id);
        $this->user->save($user);
    }
}