<?php

namespace shop\shipping\np\helpers;

class NpSearchSettlementHelper
{
    public $calledMethod;
    public $cityName;
    public $limit;

    public function __construct($calledMethod, $cityName = null, $limit = null)
    {
        $this->calledMethod = $calledMethod;
        $this->cityName = $cityName;
        $this->limit = $limit;
    }
}