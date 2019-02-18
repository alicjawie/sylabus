<?php

namespace Tests\AppBundle\Form;

trait FromArrayTrait
{
    public function fromArray($data, $object)
    {
        foreach ($data as $property => $value) {
            $method = "set{$property}";
            $object->$method($value);
        }

        return $object;
    }
}
