<?php

namespace shop\entities\User;

use Webmozart\Assert\Assert;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_networks".
 *
 * @property int $id
 * @property int $user_id
 * @property string $identity
 * @property string $network
 */
class Network extends ActiveRecord
{
    public static function create($network, $identity): self
    {
        Assert::notEmpty($network);
        Assert::notEmpty($identity);

        $item = new static();
        $item->network = $network;
        $item->identity = $identity;
        return $item;
    }

    public function isFor($network, $identity): bool
    {
        return $this->network === $network && $this->identity === $identity;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_networks}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
