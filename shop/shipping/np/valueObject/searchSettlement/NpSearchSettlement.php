<?php

namespace shop\shipping\np\valueObject\searchSettlement;

use shop\shipping\np\helpers\NpSearchSettlementHelper;
use shop\shipping\np\valueObject\NpCalledMethod;
use shop\shipping\np\valueObject\NpModelName;
use shop\shipping\np\valueObject\NpValueTrait;

class NpSearchSettlement implements NpModelName, NpCalledMethod
{
    private $modelName;
    private $calledMethod;
    private $cityName;
    private $limit;
    /** @var array*/
    private $methodProperties;

    /* data from From Np */
    public $present;
    public $warehouses;
    public $mainDescription;
    public $area;
    public $ref;
    public $deliveryCity;
    public $parentRegionCode;

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
     * @return NpSearchSettlement
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
     * @return NpSearchSettlement
     */
    public function setCalledMethod($calledMethod)
    {
        $this->calledMethod = $calledMethod;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * @param $cityName
     * @return NpSearchSettlement
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;
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
     * @return NpSearchSettlement
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
     * @return NpSearchSettlement
     */
    public function setMethodProperties()
    {
        $this->methodProperties = [
            'CityName' => $this->getCityName(),
            'Limit' => $this->getLimit()
        ];

        return $this;
    }

    // From Np

    /**
     * @return mixed
     */
    public function getPresent()
    {
        return $this->present;
    }

    /**
     * @param $present
     * @return NpSearchSettlement
     */
    public function setPresent($present)
    {
        $this->present = $present;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWarehouses()
    {
        return $this->warehouses;
    }

    /**
     * @param $warehouses
     * @return NpSearchSettlement
     */
    public function setWarehouses($warehouses)
    {
        $this->warehouses = $warehouses;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMainDescription()
    {
        return $this->mainDescription;
    }

    /**
     * @param $mainDescription
     * @return NpSearchSettlement
     */
    public function setMainDescription($mainDescription)
    {
        $this->mainDescription = $mainDescription;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param $area
     * @return NpSearchSettlement
     */
    public function setArea($area)
    {
        $this->area = $area;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param $ref
     * @return NpSearchSettlement
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeliveryCity()
    {
        return $this->deliveryCity;
    }

    /**
     * @param $deliveryCity
     * @return NpSearchSettlement
     */
    public function setDeliveryCity($deliveryCity)
    {
        $this->deliveryCity = $deliveryCity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParentRegionCode()
    {
        return $this->parentRegionCode;
    }

    /**
     * @param $parentRegionCode
     * @return NpSearchSettlement
     */
    public function setParentRegionCode($parentRegionCode)
    {
        $this->parentRegionCode = $parentRegionCode;
        return $this;
    }

    /**
     * @param NpSearchSettlementHelper $searchSetHelper
     * @return NpSearchSettlement
     */
    public static function createSearchSettlements(NpSearchSettlementHelper $searchSetHelper): self
    {
        $search = new static();
        $search
            ->setModelName()
            ->setCalledMethod($searchSetHelper->calledMethod)
            ->setCityName($searchSetHelper->cityName)
            ->setLimit($searchSetHelper->limit)
            ->setMethodProperties();
        return $search;
    }
}