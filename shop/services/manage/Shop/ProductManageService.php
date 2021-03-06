<?php

namespace shop\services\manage\Shop;

use shop\forms\manage\Shop\Product\CategoriesForm;
use shop\forms\manage\Shop\Product\ImportForm;
use shop\forms\manage\Shop\Product\QuantityForm;
use shop\forms\manage\Shop\Product\ModificationForm;
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
use shop\services\ProductReader;
use shop\services\TransactionManager;

class ProductManageService
{
    private $productRepository;
    private $brandRepository;
    private $categoryRepository;
    private $tagRepository;
    private $transaction;
    private $reader;

    public function __construct
    (
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        BrandRepository $brandRepository,
        TagRepository $tagRepository,
        TransactionManager $transaction,
        ProductReader $reader
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->tagRepository = $tagRepository;
        $this->transaction = $transaction;
        $this->reader = $reader;
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
            $form->weight,
            $form->quantity->quantity,
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

        foreach ($form->relatedProducts->products as $relatedProductOne) {
            $relatedOne = $this->productRepository->get($relatedProductOne);
            $product->assignRelatedProduct($relatedOne->id);
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
            $form->weight,
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
            foreach ($product->relatedAssignments as $relatedProduct) {
                $relateId = $relatedProduct->related_id;
                $product->revokeRelatedProduct($relateId);
            }
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

            foreach ($form->relatedProducts->products as $relatedProductOne) {
                $relatedOne = $this->productRepository->get($relatedProductOne);
                $product->assignRelatedProduct($relatedOne->id);
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

    public function changeQuantity($id, QuantityForm $form): void
    {
        $product = $this->productRepository->get($id);
        $product->setQuantity($form->quantity);
        $this->productRepository->save($product);
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
            $form->price,
            $form->quantity
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
            $form->price,
            $form->quantity
        );
        $this->productRepository->save($product);
    }

    public function removeModification($id, $modificationId): void
    {
        $product = $this->productRepository->get($id);
        $product->removeModification($modificationId);
        $this->productRepository->save($product);
    }

    public function importProduct(ImportForm $form): void
    {
        $this->transaction->wrap(function () use ($form) {
            $fileServer = \Yii::$aliases['@fileCsv'] . '/' . $form->filesCsv->name;
            if (is_file($fileServer)) {
                $results = $this->reader->readCsv($fileServer);
                foreach ($results as $resultOne) {
                    $product = $this->productRepository->getProductByCode($resultOne->code);
                    if ($product) {
                        $product->edit(
                            $resultOne->brandId,
                            $resultOne->code,
                            $resultOne->name,
                            $resultOne->description,
                            new Meta(
                                '',
                                '',
                                ''
                            )
                        );
                        $product->setPrice($resultOne->priceNew, $resultOne->priceOld);
                        $product->changeMainCategory($resultOne->categoryId);
                        $this->productRepository->save($product);
                    } else {
                        $product = Product::create(
                            $resultOne->brandId,
                            $resultOne->categoryId,
                            $resultOne->code,
                            $resultOne->name,
                            $resultOne->description,
                            new Meta(
                                '',
                                '',
                                ''
                            )
                        );
                        $this->productRepository->save($product);
                        $product->setPrice($resultOne->priceNew, $resultOne->priceOld);
                        $product->changeMainCategory($resultOne->categoryId);
                        $this->productRepository->save($product);
                    }
                }
            }
        });
    }

    public function activate($id): void
    {
        $product = $this->productRepository->get($id);
        $product->activate();
        $this->productRepository->save($product);
    }

    public function draft($id): void
    {
        $product = $this->productRepository->get($id);
        $product->draft();
        $this->productRepository->save($product);
    }

    public function activateFeatured($id): void
    {
        $product = $this->productRepository->get($id);
        $product->activateFeatured();
        $this->productRepository->save($product);
    }

    public function deactivateFeatured($id): void
    {
        $product = $this->productRepository->get($id);
        $product->deactivateFeatured();
        $this->productRepository->save($product);
    }

    public function remove($id): void
    {
        $product = $this->productRepository->get($id);
        $this->productRepository->remove($product);
    }
}