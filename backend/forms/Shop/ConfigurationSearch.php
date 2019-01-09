<?php

namespace backend\forms\Shop;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\entities\Shop\Configuration;

class ConfigurationSearch extends Model
{
    public $id;
    public $configuration_title;
    public $configuration_value;

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['configuration_title', 'configuration_value'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Configuration::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['configuration_title' => SORT_ASC]
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

        $query
            ->andFilterWhere(['like', 'configuration_title', $this->configuration_title])
            ->andFilterWhere(['like', 'configuration_value', $this->configuration_value]);

        return $dataProvider;
    }
}