<?php
namespace frontend\controllers;

use shop\shipping\np\helpers\NpGetCitiesHelper;
use shop\shipping\np\valueObject\getCities\NpGetCities;
use shop\shipping\np\valueObject\searchSettlement\NpSearchSettlement;
use yii\web\Controller;
use shop\shipping\np\NpClient;
use shop\shipping\np\helpers\NpSearchSettlementHelper;

/**
 * Site controller
 */
class SiteController extends Controller
{
    private $np;

    public function __construct($id, $module, NpClient $np, $config = [])
    {
        $this->np = $np;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'home';
        return $this->render('index');
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSearchSettlement()
    {
        $date = new NpSearchSettlementHelper('searchSettlements', 'київ', '5');
        $address = NpSearchSettlement::createSearchSettlements($date);
        $result = $this->np->api('address')->createSearchSettlement($address);
        foreach ($result as $item) {
            /** @var $item NpSearchSettlement */
            echo '<pre>';
            var_dump($item->getMainDescription());
            echo '</pre>';
            die("\n");
        }
    }

    public function actionGetCities()
    {
        $date = new NpGetCitiesHelper('getCities');
        $cities = NpGetCities::createCities($date);
        $result = $this->np->api('address')->createCities($cities);
        foreach ($result as $item) {
            /** @var $item NpGetCities */
            echo '<pre>';
            var_dump($item->getArea());
            echo '</pre>';
            die("\n");
        }
    }
}
