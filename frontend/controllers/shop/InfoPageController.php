<?php

namespace frontend\controllers\shop;

use shop\readModels\shop\InfoPageReadRepository;
use yii\web\Controller;

class InfoPageController extends Controller
{
    public $layout = 'blank';

    private $infoPageReadRepository;

    public function __construct($id, $module, InfoPageReadRepository $infoPageReadRepository, $config = [])
    {
        $this->infoPageReadRepository = $infoPageReadRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionView($id)
    {
        $infoPage = $this->infoPageReadRepository->getInfoPage($id);

        return $this->render('view', [
            'infoPage' => $infoPage
        ]);
    }
}