<?php

namespace shop\shipping\np\endPoints;

trait NpApiTrait
{
    public function objectToObject($instance, $className)
    {
        $class = new $className();
        foreach ($instance as $key => $value) {
            if (method_exists($class, 'set' . $key)) {
                $class->{'set' . $key}($value);
            }
        }
        return $class;
    }
}