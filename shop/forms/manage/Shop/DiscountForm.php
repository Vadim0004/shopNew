<?php

namespace shop\forms\manage\Shop;

use shop\entities\Shop\Discount;
use yii\base\Model;

class DiscountForm extends Model
{
    public $percent;
    public $name;
    public $from_date;
    public $to_date;
    public $active;
    public $sort;

    private $_discount;

    public function __construct(Discount $discount = null, $config = [])
    {
        if ($discount) {
            $this->percent = $discount->percent;
            $this->name = $discount->name;
            $this->from_date = $discount->from_date;
            $this->to_date = $discount->to_date;
            $this->active = $discount->active;
            $this->sort = $discount->sort;
            $this->_discount = $discount;
        } else {
            $this->sort = Discount::find()->max('sort') + 1;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'from_date', 'to_date', 'percent'], 'required'],
            [['from_date', 'to_date'], 'date', 'format' => 'php:j-F-Y'],
            [['active'], 'boolean'],
            [['sort'], 'integer'],
            [['name'], 'unique', 'targetClass' => Discount::class, 'filter' => $this->_discount ? ['<>', 'id', $this->_discount->id] : null]
        ];
    }

}