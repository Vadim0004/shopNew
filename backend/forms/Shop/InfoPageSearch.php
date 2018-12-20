<?php

namespace backend\forms\Shop;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\entities\Shop\InfoPage\InfoPage;
use shop\helpers\InfoPageHelper;
use shop\helpers\InfoPageStatusHelper;

class InfoPageSearch extends Model
{
    public $id;
    public $name;
    public $title;
    public $status;
    public $sys_id;
    public $sort;
    public $slug;
    public $meta_json;
    public $main_content;
    public $description;

    public function rules()
    {
        return [
            [['id', 'status', 'sort', 'sys_id'], 'integer'],
            [['name', 'title', 'slug', 'meta_json', 'main_content', 'description'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = InfoPage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'sys_id' => $this->sys_id,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'meta_json', $this->meta_json])
            ->andFilterWhere(['like', 'top_content', $this->main_content])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    public function statusList(): array
    {
        return InfoPageHelper::statusList();
    }

    public function sysIdList(): array
    {
        return InfoPageStatusHelper::statusList();
    }
}