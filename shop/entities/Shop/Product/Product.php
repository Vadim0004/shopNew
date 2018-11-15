<?php

namespace shop\entities\Shop\Product;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use shop\entities\Meta;
use shop\entities\Shop\Product\queries\ProductQuery;
use shop\entities\Shop\Category;
use yii\db\ActiveQuery;
use shop\entities\behaviors\MetaBehavior;
use shop\entities\User\WishlistItem;
use yii\db\ActiveRecord;
use shop\entities\Shop\Brand;
use shop\entities\Shop\Tag;
use yii\web\UploadedFile;

/**
 * This is the model class for table "shop_products".
 *
 * @property int $id
 * @property int $category_id
 * @property int $brand_id
 * @property string $created_at
 * @property string $code
 * @property string $name
 * @property string $description
 * @property int $price_old
 * @property int $price_new
 * @property string $rating
 * @property integer $main_photo_id
 * @property string $meta_json
 * @property int $status
 * @property int $is_featured
 * @property int $weight
 * @property int $quantity
 *
 * @property Meta $meta
 * @property Brand $brand
 * @property Category $category
 * @property CategoryAssignment[] $categoryAssignments
 * @property Category[] $categories
 * @property TagAssignment[] $tagAssignments
 * @property Tag[] $tags
 * @property RelatedAssignment[] $relatedAssignments
 * @property Modification[] $modifications
 * @property Value[] $values
 * @property Photo[] $images
 * @property Photo $mainPhoto
 * @property Review[] $reviews
 */
class Product extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_FEATURED_ON = 1;
    const STATUS_FEATURED_OFF = 0;

    public $meta;

    public static function create($brandId, $categoryId, $code, $name, $description, $weight, $quantity, Meta $meta): self
    {
        $product = new static();
        $product->brand_id = $brandId;
        $product->category_id = $categoryId;
        $product->code = $code;
        $product->name = $name;
        $product->description = $description;
        $product->weight = $weight;
        $product->quantity = $quantity;
        $product->meta = $meta;
        $product->status = self::STATUS_DRAFT;
        $product->is_featured = self::STATUS_FEATURED_OFF;
        $product->created_at = time();
        return $product;
    }

    public function setQuantity($quantity): void
    {
        if ($this->modifications) {
            throw new \DomainException('Change modifications quantity.');
        }
        $this->quantity = $quantity;
    }

    public function edit($brandId, $code, $name, $description, $weight, Meta $meta): void
    {
        $this->brand_id = $brandId;
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->weight = $weight;
        $this->meta = $meta;
    }

    public function setPrice($new, $old): void
    {
        $this->price_new = $new;
        $this->price_old = $old;
    }

    public function changeMainCategory($categoryId): void
    {
        $this->category_id = $categoryId;
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Product is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        if ($this->isDraft()) {
            throw new \DomainException('Product is already draft.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function isAvailable(): bool
    {
        return $this->quantity > 0;
    }

    public function canChangeQuantity(): bool
    {
        return !$this->modifications;
    }

    public function canBeCheckout($modificationId, $quantity): bool
    {
        if ($modificationId) {
            return $quantity <= $this->getModification($modificationId)->quantity;
        }
        return $quantity <= $this->quantity;
    }

    public function checkout($modificationId, $quantity): void
    {
        if ($modificationId) {
            $modifications = $this->modifications;
            foreach ($modifications as $i => $modification) {
                if ($modification->isIdEqualTo($modificationId)) {
                    $modification->checkout($quantity);
                    $this->updateModifications($modifications);
                    return;
                }
            }
        }
        if ($quantity > $this->quantity) {
            throw new \DomainException('Only ' . $this->quantity . ' items are available.');
        }
        $this->quantity -= $quantity;
    }

    public function activateFeatured(): void
    {
        if ($this->isActiveFeatured()) {
            throw new \DomainException('Product is already featured.');
        }
        $this->is_featured = self::STATUS_FEATURED_ON;
    }

    public function deactivateFeatured(): void
    {
        if ($this->isDeactivateFeatured()) {
            throw new \DomainException('Product is already deactivate fo featured.');
        }
        $this->is_featured = self::STATUS_FEATURED_OFF;
    }

    public function isActiveFeatured(): bool
    {
        return $this->is_featured == self::STATUS_FEATURED_ON;
    }

    public function isDeactivateFeatured(): bool
    {
        return $this->is_featured == self::STATUS_FEATURED_OFF;
    }

    public function getSeoTitle(): string
    {
        return $this->meta->title ?: $this->name;
    }

    public function assignCategory($id): void
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForCategory($id)) {
                return;
            }
        }
        $assignments[] = CategoryAssignment::create($id);
        $this->categoryAssignments = $assignments;
    }

    public function revokeCategory($id): void
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForCategory($id)) {
                unset($assignments[$i]);
                $this->categoryAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function setValue($id, $value): void
    {
        $values = $this->values;
        foreach ($values as $val) {
            if ($val->isForCharacteristic($id)) {
                $val->change($value);
                $this->values = $values;
                return;
            }
        }
        $values[] = Value::create($id, $value);
        $this->values = $values;
    }

    public function getValue($id): Value
    {
        $values = $this->values;
        foreach ($values as $val) {
            if ($val->isForCharacteristic($id)) {
                return $val;
            }
        }
        return Value::blank($id);
    }

    public function revokeCategories(): void
    {
        $this->categoryAssignments = [];
    }

    // Photo

    public function addPhoto(UploadedFile $file): void
    {
        $photos = $this->images;
        $photos[] = Photo::create($file);
        $this->updatePhotos($photos);
    }

    public function removePhoto($id): void
    {
        $photos = $this->images;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                unset($photos[$i]);
                $this->updatePhotos($photos);
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    private function updatePhotos(array $photos): void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->images = $photos;
        $this->populateRelation('mainPhoto', reset($photos));
    }

    public function movePhotoUp($id): void
    {
        $photos = $this->images;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($prev = $photos[$i - 1] ?? null) {
                    $photos[$i - 1] = $photo;
                    $photos[$i] = $prev;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    public function movePhotoDown($id): void
    {
        $photos = $this->images;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($next = $photos[$i + 1] ?? null) {
                    $photos[$i] = $next;
                    $photos[$i + 1] = $photo;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    public function setPhotos(array $photos): void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->images = $photos;
    }

    public function removePhotos(): void
    {
        $this->updatePhotos([]);
    }

    // Tags

    public function assignTag($id): void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForTag($id)) {
                return;
            }
        }
        $assignments[] = TagAssignment::create($id);
        $this->tagAssignments = $assignments;
    }

    public function revokeTag($id): void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForTag($id)) {
                unset($assignments[$i]);
                $this->tagAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeTags(): void
    {
        $this->tagAssignments = [];
    }

    // Related products

    public function assignRelatedProduct($id): void
    {
        $assignments = $this->relatedAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForProduct($id)) {
                return;
            }
        }
        $assignments[] = RelatedAssignment::create($id);
        $this->relatedAssignments = $assignments;
    }

    public function revokeRelatedProduct($id): void
    {
        $assignments = $this->relatedAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForProduct($id)) {
                unset($assignments[$i]);
                $this->relatedAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    // Modification

    public function getModification($id): Modification
    {
        foreach ($this->modifications as $modification) {
            if ($modification->isIdEqualTo($id)) {
                return $modification;
            }
        }
        throw new \DomainException('Modification is not found.');
    }

    public function addModification($code, $name, $price, $quantity): void
    {
        $modifications = $this->modifications;
        foreach ($modifications as $modification) {
            if ($modification->isCodeEqualTo($code)) {
                throw new \DomainException('Modification already exists.');
            }
        }
        $modifications[] = Modification::create($code, $name, $price, $quantity);
        $this->updateModifications($modifications);
    }

    public function editModification($id, $code, $name, $price, $quantity): void
    {
        $modifications = $this->modifications;
        foreach ($modifications as $i => $modification) {
            if ($modification->isIdEqualTo($id)) {
                $modification->edit($code, $name, $price, $quantity);
                $this->updateModifications($modifications);
                return;
            }
        }
        throw new \DomainException('Modification is not found.');
    }

    public function removeModification($id): void
    {
        $modifications = $this->modifications;
        foreach ($modifications as $i => $modification) {
            if ($modification->isIdEqualTo($id)) {
                unset($modifications[$i]);
                $this->updateModifications($modifications);
                return;
            }
        }
        throw new \DomainException('Modification is not found.');
    }

    public function getModificationPrice($id): int
    {
        foreach ($this->modifications as $modification) {
            if ($modification->isIdEqualTo($id)) {
                return $modification->price ?: $this->price_new;
            }
        }
        throw new \DomainException('Modification is not found.');
    }

    private function updateModifications(array $modifications): void
    {
        $this->modifications = $modifications;
        $this->quantity = array_sum(array_map(function (Modification $modification) {
            return $modification->quantity;
        }, $this->modifications));
    }

    // Reviews

    public function addReview($userId, $vote, $text): void
    {
        $reviews = $this->reviews;
        $reviews[] = Review::create($userId, $vote, $text);
        $this->setReviews($reviews);
    }

    public function editReview($id, $vote, $text): void
    {
        $reviews = $this->reviews;
        foreach ($reviews as $i => $review) {
            if ($review->isIdEqualTo($id)) {
                $review->edit($vote, $text);
                $this->setReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Review is not found.');
    }

    public function activateReview($id)
    {
        $reviews = $this->reviews;
        foreach ($reviews as $i => $review) {
            if ($review->isIdEqualTo($id)) {
                $review->activate();
                $this->setReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Review is not found.');
    }

    public function draftReview($id): void
    {
        $reviews = $this->reviews;
        foreach ($reviews as $i => $review) {
            if ($review->isIdEqualTo($id)) {
                $review->draft();
                $this->setReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Review is not found.');
    }

    public function removeReview($id): void
    {
        $reviews = $this->reviews;
        foreach ($reviews as $i => $review) {
            if ($review->isIdEqualTo($id)) {
                unset($reviews[$i]);
                $this->setReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Review is not found.');
    }

    private function setReviews(array $reviews): void
    {
        $amount = 0;
        $total = 0;

        foreach ($reviews as $review) {
            if ($review->isActive()) {
                $amount++;
                $total += $review->getRating();
            }
        }

        $this->reviews = $reviews;
        $this->rating = $amount ? $total / $amount : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shop_products}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand(): ActiveQuery
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getCategoryAssignments(): ActiveQuery
    {
        return $this->hasMany(CategoryAssignment::class, ['product_id' => 'id']);
    }

    public function getValues(): ActiveQuery
    {
        return $this->hasMany(Value::class, ['product_id' => 'id']);
    }

    public function getImages(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['product_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getTagAssignments(): ActiveQuery
    {
        return $this->hasMany(TagAssignment::class, ['product_id' => 'id']);
    }

    public function getRelatedAssignments(): ActiveQuery
    {
        return $this->hasMany(RelatedAssignment::class, ['product_id' => 'id']);
    }

    public function getRelateds(): ActiveQuery
    {
        return $this->hasMany(Product::class, ['id' => 'related_id'])->via('relatedAssignments');
    }

    public function getModifications(): ActiveQuery
    {
        return $this->hasMany(Modification::class, ['product_id' => 'id']);
    }

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(Review::class, ['product_id' => 'id']);
    }

    public function getWishlistItems(): ActiveQuery
    {
        return $this->hasMany(WishlistItem::class, ['product_id' => 'id']);
    }

    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('categoryAssignments');
    }

    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['categoryAssignments', 'values', 'images', 'tagAssignments', 'relatedAssignments', 'modifications', 'categories', 'tags'],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->images as $photo) {
                $photo->delete();
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes): void
    {
        $related = $this->getRelatedRecords();
        parent::afterSave($insert, $changedAttributes);
        if (array_key_exists('mainPhoto', $related)) {
            $this->updateAttributes(['main_photo_id' => $related['mainPhoto'] ? $related['mainPhoto']->id : null]);
        }
    }

    public static function find(): ProductQuery
    {
        return new ProductQuery(static::class);
    }
}
