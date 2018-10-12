<?php

namespace shop\services\manage\Shop;

use shop\repositories\Shop\CategoryRepository;
use shop\entities\Shop\Category;
use shop\forms\manage\Shop\CategoryForm;
use shop\entities\Meta;
use shop\repositories\Shop\ProductRepository;

class CategoryManageService
{
    private $categoryRepository;
    private $productsRepository;

    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productsRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productsRepository = $productsRepository;
    }

    public function create(CategoryForm $form): Category
    {
        $parent = $this->categoryRepository->get($form->parentId);
        $category = Category::create(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $category->appendTo($parent);
        $this->categoryRepository->save($category);
        return $category;
    }

    public function edit($id, CategoryForm $form): void
    {
        $category = $this->categoryRepository->get($id);
        $this->assertIsNotRoot($category);
        $category->edit(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        if ($form->parentId !== $category->parent->id) {
            $parent = $this->categoryRepository->get($form->parentId);
            $category->appendTo($parent);
        }
        $this->categoryRepository->save($category);
    }

    public function moveUp($id): void
    {
        $category = $this->categoryRepository->get($id);
        $this->assertIsNotRoot($category);
        if ($prev = $category->prev) {
            $category->insertBefore($prev);
        }
        $this->categoryRepository->save($category);
    }

    public function moveDown($id): void
    {
        $category = $this->categoryRepository->get($id);
        $this->assertIsNotRoot($category);
        if ($next = $category->next) {
            $category->insertAfter($next);
        }
        $this->categoryRepository->save($category);
    }

    public function remove($id): void
    {
        $category = $this->categoryRepository->get($id);
        $this->assertIsNotRoot($category);
        if ($this->productsRepository->existsByMainCategory($category->id)) {
            throw new \DomainException('Unable to remove category with products.');
        }
        $this->categoryRepository->remove($category);
    }

    private function assertIsNotRoot(Category $category): void
    {
        if ($category->isRoot()) {
            throw new \DomainException('Unable to manage the root category.');
        }
    }
}