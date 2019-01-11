<?php

namespace shop\shipping\np\valueObject;


trait NpValueTrait
{
    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}