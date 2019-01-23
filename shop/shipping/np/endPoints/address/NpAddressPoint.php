<?php

namespace shop\shipping\np\endPoints\address;

use shop\shipping\np\endPoints\NpAbstractApi;
use shop\shipping\np\endPoints\NpApiTrait;
use shop\shipping\np\valueObject\getCities\NpGetCities;
use shop\shipping\np\valueObject\searchSettlement\NpSearchSettlement;
use shop\shipping\np\valueObject\searchSettlementStreets\NpSearchSettlementStreets;

class NpAddressPoint extends NpAbstractApi
{
    use NpApiTrait;

    /**
     * @param NpSearchSettlement $search
     * @return mixed
     */
    public function createSearchSettlement(NpSearchSettlement $search): array
    {
        $options = [
            'json' => $search->toArray()
        ];
        $resultFromNp = $this->post($options);
        $validate = $this->validateErrors($resultFromNp);
        if ($validate) {
            $searchSettlement = $resultFromNp->data[0]->Addresses;
            /** @var NpSearchSettlement[] */
            $result = [];
            foreach ($searchSettlement as $itemElement) {
                $result[] = $this->objectToObject($itemElement, NpSearchSettlement::class);
            }
            return $result;
        }
    }

    /**
     * @param NpGetCities $cities
     * @return mixed
     */
    public function createCities(NpGetCities $cities): array
    {
        $options = [
            'json' => $cities->toArray()
        ];
        $resultFromNp = $this->post($options);
        $validate = $this->validateErrors($resultFromNp);
        if ($validate) {
            $citiesElement = $resultFromNp->data;
            /** @var NpGetCities[] */
            $result = [];
            foreach ($citiesElement as $itemElement) {
                $result[] = $this->objectToObject($itemElement, NpGetCities::class);
            }
            return $result;
        }
    }

    /**
     * @param NpSearchSettlementStreets $search
     * @return mixed
     */
    public function createSearchSettlementStreets(NpSearchSettlementStreets $search): array
    {
        $options = [
            'json' => $search->toArray()
        ];
        $resultFromNp = $this->post($options);
        $validate = $this->validateErrors($resultFromNp);
        if ($validate) {
            $citiesElement = $resultFromNp->data;
            /** @var NpSearchSettlementStreets[] */
            $result = [];
            foreach ($citiesElement as $itemElement) {
                $result[] = $this->objectToObject($itemElement, NpSearchSettlementStreets::class);
            }
            return $result;
        }
    }
}