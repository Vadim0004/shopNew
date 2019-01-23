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

    /**
     * @param \stdClass $class
     * @return \stdClass|\DomainException
     */
    public function validateErrors(\stdClass $class): ?\stdClass
    {
        if (isset($class->errors)) {
            foreach ($class->errors as $error) {
                throw new \DomainException("Error . $error");
            }
        }
        return $class;
    }
}