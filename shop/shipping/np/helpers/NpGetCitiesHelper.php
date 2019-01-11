<?php

namespace shop\shipping\np\helpers;

class NpGetCitiesHelper
{
    public $calledMethod;
    public $ref;

    public function __construct($calledMethod, $ref = null)
    {
        $this->calledMethod = $calledMethod;
        $this->ref = $ref;
    }
}