<?php

namespace shop\entities\Shop\InfoPage\queries;

use shop\entities\Shop\InfoPage\InfoPage;
use yii\db\ActiveQuery;

class InfoPageQuery extends ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => InfoPage::STATUS_ACTIVE,
        ]);
    }
}