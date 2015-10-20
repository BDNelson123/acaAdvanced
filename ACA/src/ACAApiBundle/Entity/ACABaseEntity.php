<?php

namespace ACAApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Util\Inflector;

/**
 * @ORM\MappedSuperclass()
 */
class ACABaseEntity
{
    /**
     * @return array
     */
    public function getData()
    {
        $data =[];

        foreach($this->fields as $field) {
            $data[$field] = $this->{$field};
        }

        return $data;
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        foreach($data as $field => $value) {
            $insert = Inflector::camelize(str_replace('_', ' ', $field));
            $insert = ucfirst($insert);
            $insert = 'set' . $insert;
            $this->$insert($data[$field]);
        }

        return $data;

    }
}

/*
 * 1) $data->name == $data->{"name"}
 * 2) $variable = function;
 *      $variable();
 * 3)
 */
