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

            //Ex: user_id => user id => userId => UserId => setUserId
            $setter_method_name = Inflector::camelize(str_replace('_', ' ', $field));
            $setter_method_name = ucfirst($setter_method_name);
            $setter_method_name = 'set' . $setter_method_name;
            $this->$setter_method_name($value);
        }

        return $data;

    }
}
