<?php

namespace backend\forms\Shop;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\entities\Shop\Discount;

class DiscountSearch extends Model
{
    public $id;
    public $name;
    public $active;
    public $from_date;
    public $to_date;
    public $date_from;
    public $date_to;

    public function rules(): array
    {
        return [
            [['id', 'active'], 'integer'],
            ['name', 'safe'],
            [['from_date', 'to_date', 'date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Discount::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sort' => SORT_DESC]
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['>=', 'from_date', $this->from_date]);
        $query->andFilterWhere(['<=', 'from_date', $this->to_date]);
        $query->andFilterWhere(['>=', 'to_date', $this->date_from]);
        $query->andFilterWhere(['<=', 'to_date', $this->date_to]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'active', $this->active]);

        return $dataProvider;
    }

    public function requiredList(): array
    {
        return [
            1 => \Yii::$app->formatter->asBoolean(true),
            0 => \Yii::$app->formatter->asBoolean(false),
        ];
    }
}