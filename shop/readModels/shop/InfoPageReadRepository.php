<?php

namespace shop\readModels\shop;

use shop\entities\Shop\InfoPage\InfoPage;

class InfoPageReadRepository
{
    public function getInfoPage(int $id): ?InfoPage
    {
        return InfoPage::find()->active()->andWhere(['id' => $id])->one();
    }

    public function getInfoPageByStatusPage($status)
    {
        $infoPage = InfoPage::find()
            ->alias('ip')
            ->where(['sys_id' => $status])
            ->active('ip')
            ->all();
        return $infoPage;
    }
}