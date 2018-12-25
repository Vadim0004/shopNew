<?php

namespace frontend\widgets\shop;

use shop\readModels\shop\InfoPageReadRepository;
use yii\base\Widget;            

class InfoPageWidget extends Widget
{
    public $pageStatus;

    private $infoPageRepository;

    public function __construct(InfoPageReadRepository $infoPageRepository ,$config = [])
    {
        $this->infoPageRepository = $infoPageRepository;
        parent::__construct($config);
    }

    public function run()
    {
        $infoPage = $this->infoPageRepository->getInfoPageByStatusPage($this->pageStatus);

        return $this->render('InfoPage', [
            'infoPage' => $infoPage,
        ]);
    }
}