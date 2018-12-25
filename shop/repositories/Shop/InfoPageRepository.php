<?php

namespace shop\repositories\Shop;

use shop\entities\Shop\InfoPage\InfoPage;
use shop\repositories\NotFoundException;

class InfoPageRepository
{
    public function get($id): InfoPage
    {
        if (!$infoPage = InfoPage::findOne($id)) {
            throw new NotFoundException('Info Page is not found.');
        }
        return $infoPage;
    }

    public function save(InfoPage $infoPage): void
    {
        if (!$infoPage->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(InfoPage $infoPage): void
    {
        if (!$infoPage->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function getSliderToInfoPage(string $sliderId)
    {
        $infoPage = InfoPage::find()->select(['id', 'name', 'slider_name', 'sys_statuses_json'])->where(['slider_name' => $sliderId])->one();
        /** @var InfoPage $infoPage*/
        if ($infoPage) {
            throw new \DomainException("This slider is already attach to Info page '$infoPage->name'");
        } else {
            return $infoPage;
        }
    }
}