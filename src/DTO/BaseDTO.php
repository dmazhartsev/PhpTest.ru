<?php

namespace App\DTO;

use ReflectionClass;

abstract class BaseDTO
{
    public function init(array $post): self
    {
        $reflect = new ReflectionClass($this);

        foreach ($reflect->getProperties() as $property) {
            $propertyName = $property->getName();

            if (isset($post[$propertyName])) {
                if (!$this->checkValue($post[$propertyName])) {
                    continue;
                }
                $this->$propertyName = $post[$propertyName];
            } elseif (!$property->getType()->isBuiltin()) {
                $prop = new ReflectionClass($property->getType()->getName());
                $this->$propertyName = $prop->newInstance();
                $this->$propertyName->init($post);
            } else {
                $this->$propertyName = null;
            }
        }

        return $this;
    }

    abstract protected function checkValue(string $value): bool;

    public function toArray(): array
    {
        $reflect = new ReflectionClass($this);
        $properties = $reflect->getProperties();
        $array = [];

        foreach ($properties as $property) {
            $propertyName = $property->getName();

            if ($this->$propertyName === null) {
                $array[$propertyName] = '';
            } elseif ($property->getType()->isBuiltin()) {
                $array[$propertyName] = $this->$propertyName;
            } elseif ($this->$propertyName instanceof self) {
                $array[$propertyName] = $this->$propertyName->toArray();
            }
        }
        return $array;
    }
}