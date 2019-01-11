<?php

namespace shop\shipping\np\valueObject\getCities;

use shop\shipping\np\helpers\NpGetCitiesHelper;
use shop\shipping\np\valueObject\NpCalledMethod;
use shop\shipping\np\valueObject\NpModelName;
use shop\shipping\np\valueObject\NpValueTrait;

class NpGetCities implements NpModelName, NpCalledMethod
{
    private $modelName;
    private $calledMethod;
    private $ref;
    /** @var array*/
    private $methodProperties;

    /* data from From Np */
    private $description;
    private $descriptionRu;
    private $area;
    private $cityId;
    private $settlementTypeDescription;
    private $settlementTypeDescriptionRu;

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
     * @return NpGetCities
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
     * @return NpGetCities
     */
    public function setCalledMethod($calledMethod)
    {
        $this->calledMethod = $calledMethod;
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
     * @return NpGetCities
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
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
     * @return NpGetCities
     */
    public function setMethodProperties()
    {
        $this->methodProperties = [
            'Ref' => $this->getRef(),
        ];

        return $this;
    }

    // From Np

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return NpGetCities
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescriptionRu()
    {
        return $this->descriptionRu;
    }

    /**
     * @param $descriptionRu
     * @return NpGetCities
     */
    public function setDescriptionRu($descriptionRu)
    {
        $this->descriptionRu = $descriptionRu;
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
     * @return NpGetCities
     */
    public function setArea($area)
    {
        $this->area = $area;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCityID()
    {
        return $this->cityId;
    }

    /**
     * @param $cityId
     * @return NpGetCities
     */
    public function setCityID($cityId)
    {
        $this->cityId = $cityId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSettlementTypeDescription()
    {
        return $this->settlementTypeDescription;
    }

    /**
     * @param $typeDescription
     * @return NpGetCities
     */
    public function setSettlementTypeDescription($typeDescription)
    {
        $this->settlementTypeDescription = $typeDescription;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSettlementTypeDescriptionRu()
    {
        return $this->settlementTypeDescriptionRu;
    }

    /**
     * @param $typeDescriptionRu
     * @return NpGetCities
     */
    public function setSettlementTypeDescriptionRu($typeDescriptionRu)
    {
        $this->settlementTypeDescriptionRu = $typeDescriptionRu;
        return $this;
    }

    /**
     * @param NpGetCitiesHelper $citiesHelper
     * @return NpGetCities
     */
    public static function createCities(NpGetCitiesHelper $citiesHelper): self
    {
        $cities = new static();
        $cities
            ->setModelName()
            ->setCalledMethod($citiesHelper->calledMethod)
            ->setRef($citiesHelper->ref)
            ->setMethodProperties();
        return $cities;
    }

}