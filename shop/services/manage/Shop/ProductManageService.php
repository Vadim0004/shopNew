<?php

namespace shop\services\manage\Shop;

use shop\forms\manage\Shop\Product\CategoriesForm;
use shop\repositories\Shop\BrandRepository;
use shop\repositories\Shop\CategoryRepository;
use shop\repositories\Shop\ProductRepository;
use shop\repositories\Shop\TagRepository;
use shop\entities\Shop\Tag;
use shop\entities\Meta;
use shop\entities\Shop\Product\Product;
use shop\forms\manage\Shop\Product\ProductCreateForm;
use shop\forms\manage\Shop\Product\PhotosForm;
use shop\forms\manage\Shop\Product\ProductEditForm;
use shop\services\TransactionManager;

class ProductManageService
{
    private $productRepository;
    private $brandRepository;
    private $categoryRepository;
    private $tagRepository;
    private $transaction;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        BrandRepository $brandRepository,
        TagRepository $tagRepository,
        TransactionManager $transaction)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->tagRepository = $tagRepository;
        $this->transaction = $transaction;
    }

    public function create(ProductCreateForm $form): Product
    {
        $brand = $this->brandRepository->get($form->brandId);
        $category = $this->categoryRepository->get($form->categories->main);

        $product = Product::create(
            $brand->id,
            $category->id,
            $form->code,
            $form->name,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $product->setPrice($form->price->new, $form->price->old);

        foreach ($form->categories->others as $otherId) {
            $category = $this->categoryRepository->get($otherId);
            $product->assignCategory($category->id);
        }

        foreach ($form->values as $value) {
            $product->setValue($value->id, $value->value);
        }

        foreach ($form->photos->files as $file) {
            $product->addPhoto($file);
        }

        foreach ($form->tags->existing as $tagId) {
            $tag = $this->tagRepository->get($tagId);
            $product->assignTag($tag->id);
        }

        $this->transaction->wrap(function () use ($form, $product){
            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = $this->tagRepository->findByName($tagName)) {
                    $tag = Tag::create($tagName, $tagName);
                    $this->tagRepository->save($tag);
                }
                $product->assignTag($tag->id);
            }
        });

        $this->productRepository->save($product);

        return $product;
    }

    public function edit($id, ProductEditForm $form): void
    {
        $product = $this->productRepository->get($id);
        $brand = $this->brandRepository->get($form->brandId);
        $category = $this->categoryRepository->get($form->categories->main);

        $product->edit(
            $brand->id,
            $form->code,
            $form->name,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $product->changeMainCategory($category->id);

        $this->transaction->wrap(function () use ($form, $product){

            $product->revokeCategories();
            $product->revokeTags();
            $this->productRepository->save($product);

            foreach ($form->categories->others as $otherId) {
                $category = $this->categoryRepository->get($otherId);
                $product->assignCategory($category->id);
            }

            foreach ($form->values as $value) {
                $product->setValue($value->id, $value->value);
            }

            foreach ($form->tags->existing as $tagId) {
                $tag = $this->tagRepository->get($tagId);
                $product->assignTag($tag->id);
            }

            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = $this->tagRepository->findByName($tagName)) {
                    $tag = Tag::create($tagName, $tagName);
                    $this->tagRepository->save($tag);
                }
                $product->assignTag($tag->id);
            }
            $this->productRepository->save($product);
        });
    }

    public function changeCategories($id, CategoriesForm $form): void
    {
        $product = $this->productRepository->get($id);
        $category = $this->categoryRepository->get($form->main);
        $product->changeMainCategory($category->id);
        $product->revokeCategories();
        foreach ($form->others as $otherId) {
            $category = $this->categoryRepository->get($otherId);
            $product->assignCategory($category->id);
        }
        $this->productRepository->save($product);
    }

    public function addPhotos($id, PhotosForm $form): void
    {
        $product = $this->productRepository->get($id);
        foreach ($form->files as $file) {
            $product->addPhoto($file);
        }
        $this->productRepository->save($product);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $product = $this->productRepository->get($id);
        $product->movePhotoUp($photoId);
        $this->productRepository->save($product);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $product = $this->productRepository->get($id);
        $product->movePhotoDown($photoId);
        $this->productRepository->save($product);
    }

    public function removePhotos($id, $photoId): void
    {
        $product = $this->productRepository->get($id);
        $product->removePhoto($photoId);
        $this->productRepository->save($product);
    }

    public function addModification($id, ModificationForm $form): void
    {
        $product = $this->productRepository->get($id);
        $product->addModification(
            $form->code,
            $form->name,
            $form->price
        );
        $this->productRepository->save($product);
    }

    public function editModification($id, $modificationId, ModificationForm $form): void
    {
        $product = $this->productRepository->get($id);
        $product->editModification(
            $modificationId,
            $form->code,
            $form->name,
            $form->price
        );
        $this->productRepository->save($product);
    }

    public function removeModification($id, $modificationId): void
    {
        $product = $this->productRepository->get($id);
        $product->removeModification($modificationId);
        $this->productRepository->save($product);
    }

    public function remove($id): void
    {
        $product = $this->productRepository->get($id);
        $this->productRepository->remove($product);
    }
}