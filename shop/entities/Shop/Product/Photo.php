<?php

namespace shop\entities\Shop\Product;

use shop\services\WaterMarker;
use yii\db\ActiveRecord;
use yiidreamteam\upload\ImageUploadBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "shop_photos".
 *
 * @property int $id
 * @property int $product_id
 * @property string $file
 * @property int $sort
 *
 * @property Product $products
 * @mixin ImageUploadBehavior
 */
class Photo extends ActiveRecord
{

    public static function create(UploadedFile $file): self
    {
        $photo = new static();
        $photo->file = $file;
        return $photo;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%shop_photos}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => "@webroot/upload/origin/products/[[attribute_product_id]]/[[id]].[[extension]]",
                'fileUrl' => "/backend/web/upload/origin/products/[[attribute_product_id]]/[[id]].[[extension]]",
                'thumbPath' => "@webroot/upload/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]",
                'thumbUrl' => "/backend/web/upload/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]",
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'cart_list' => ['width' => 150, 'height' => 150],
                    'catalog_list' => ['width' => 228, 'height' => 228],
                    'catalog_product_main' => ['processor' => [new WaterMarker(750, 1000, '@frontend/web/image/logo.png'), 'process']],
                    'catalog_product_additional' => ['width' => 66, 'height' => 66],
                    'catalog_origin' => ['processor' => [new WaterMarker(1024, 768, '@frontend/web/image/logo.png'), 'process']],
                ],
            ],
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
