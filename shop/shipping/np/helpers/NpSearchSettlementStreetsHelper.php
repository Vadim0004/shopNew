<?php

namespace shop\shipping\np\helpers;

class NpSearchSettlementStreetsHelper
{
    public $calledMethod;
    public $settlementRef;
    public $limit;
    public $streetName;

    public function __construct($calledMethod, $settlementRef, $limit, $streetName = null)
    {
        $this->calledMethod = $calledMethod;
        $this->settlementRef = $settlementRef;
        $this->limit = $limit;
        $this->streetName = $streetName;
    }
}