<?php

namespace shop\shipping\np\valueObject\searchSettlementStreets;

use shop\shipping\np\valueObject\NpCalledMethod;
use shop\shipping\np\valueObject\NpModelName;
use shop\shipping\np\valueObject\NpValueTrait;
use shop\shipping\np\helpers\NpSearchSettlementStreetsHelper;

class NpSearchSettlementStreets implements NpModelName, NpCalledMethod
{
    private $modelName;
    private $calledMethod;
    private $streetName;
    private $settlementRef;
    private $limit;
    /** @var array*/
    private $methodProperties;

    /* data from From Np */
    private $settlementStreetRef;
    private $settlementStreetDescription;
    private $present;
    private $streetsType;
    private $streetsTypeDescription;

    use NpValueTrait;

    /**
     * @return mixed
     */
    public function getModelName()
    {
        return $this->modelName;
    }

    /**
     * @param $modelName
     * @return NpSearchSettlementStreets
     */
    public function setModelName($modelName = 'Address')
    {
        $this->modelName = $modelName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCalledMethod()
    {
        return $this->calledMethod;
    }

    /**
     * @param $calledMethod
     * @return NpSearchSettlementStreets
     */
    public function setCalledMethod($calledMethod)
    {
        $this->calledMethod = $calledMethod;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getStreetName()
    {
        return $this->streetName;
    }

    /**
     * @param $streetName
     * @return NpSearchSettlementStreets
     */
    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSettlementRef()
    {
        return $this->settlementRef;
    }

    /**
     * @param $settlementRef
     * @return NpSearchSettlementStreets
     */
    public function setSettlementRef($settlementRef)
    {
        $this->settlementRef = $settlementRef;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param $limit
     * @return NpSearchSettlementStreets
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethodProperties()
    {
        return $this->methodProperties;
    }

    /**
     * @return NpSearchSettlementStreets
     */
    public function setMethodProperties()
    {
        $this->methodProperties = [
            'StreetName' => $this->getStreetName(),
            'SettlementRef' => $this->getSettlementRef(),
            'Limit' => $this->getLimit()
        ];

        return $this;
    }

    // From Np
    /**
     * @return mixed
     */
    public function getSettlementStreetRef()
    {
        return $this->settlementStreetRef;
    }

    /**
     * @param $settlementStreetRef
     * @return NpSearchSettlementStreets
     */
    public function setSettlementStreetRef($settlementStreetRef)
    {
        $this->settlementStreetRef = $settlementStreetRef;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSettlementStreetDescription()
    {
        return $this->settlementStreetDescription;
    }

    /**
     * @param $settlementStreetDescription
     * @return NpSearchSettlementStreets
     */
    public function setSettlementStreetDescription($settlementStreetDescription)
    {
        $this->settlementStreetDescription = $settlementStreetDescription;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPresent()
    {
        return $this->present;
    }

    /**
     * @param $present
     * @return NpSearchSettlementStreets
     */
    public function setPresent($present)
    {
        $this->present = $present;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreetsType()
    {
        return $this->streetsType;
    }

    /**
     * @param $streetsType
     * @return NpSearchSettlementStreets
     */
    public function setStreetsType($streetsType)
    {
        $this->streetsType = $streetsType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreetsTypeDescription()
    {
        return $this->streetsType;
    }

    /**
     * @param $streetsTypeDescription
     * @return NpSearchSettlementStreets
     */
    public function setStreetsTypeDescription($streetsTypeDescription)
    {
        $this->streetsTypeDescription = $streetsTypeDescription;
        return $this;
    }


    /**
     * @param NpSearchSettlementStreetsHelper $searchSettlementStreetsHelper
     * @return NpSearchSettlementStreets
     */
    public static function createSearchSettlementStreets(NpSearchSettlementStreetsHelper $searchSettlementStreetsHelper): self
    {
        $search = new static();
        $search
            ->setModelName()
            ->setSettlementRef($searchSettlementStreetsHelper->settlementRef)
            ->setCalledMethod($searchSettlementStreetsHelper->calledMethod)
            ->setStreetName($searchSettlementStreetsHelper->streetName)
            ->setLimit($searchSettlementStreetsHelper->limit)
            ->setMethodProperties();
        return $search;
    }
}