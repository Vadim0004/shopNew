<?php

namespace shop\entities\Shop;

use shop\entities\Shop\InfoPage\InfoPage;
use yii\db\ActiveRecord;
use yiidreamteam\upload\ImageUploadBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "shop_sliders".
 *
 * @property int $id
 * @property string $name
 * @property string $file
 * @property string $comment
 *
 * @property InfoPage[] $shopInfoPages
 */
class Slider extends ActiveRecord
{
    const EMPTY_PHOTO = 'empty';

    public static function create($name, $comment): self
    {
        $photo = new static();
        $photo->name = $name;
        $photo->comment = $comment;
        return $photo;
    }

    public function edit($name, $comment): void
    {
        $this->name = $name;
        $this->comment = $comment;
    }

    public function setPhoto(UploadedFile $file): void
    {
        $this->file = $file;
    }

    public function setPhotoEmpty(): void
    {
        $this->file = self::EMPTY_PHOTO;
    }

    public function removePhoto(): void
    {
        $this->file = null;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public function addPhoto(UploadedFile $file): self
    {
        $photo = $this->id;
        if ($this->isIdEqualTo($photo)) {
            $this->removePhoto();
            $this->setPhoto($file);
            return $this;
        } else {
            throw new \DomainException('Photo is not found.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{shop_sliders}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => "@webroot/upload/origin/slider/[[attribute_id]]/[[id]].[[extension]]",
                'fileUrl' => "/backend/web/upload/origin/slider/[[attribute_id]]/[[id]].[[extension]]",
                'thumbPath' => "@webroot/upload/cache/slider/[[attribute_id]]/[[profile]]_[[id]].[[extension]]",
                'thumbUrl' => "/backend/web/upload/cache/slider/[[attribute_id]]/[[profile]]_[[id]].[[extension]]",
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                ],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopInfoPages()
    {
        return $this->hasMany(InfoPage::class, ['slider_name' => 'name']);
    }
}
