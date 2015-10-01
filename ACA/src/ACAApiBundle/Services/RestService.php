<?php

namespace ACAApiBundle\Services;

use ACAApiBundle\Services\DBCommon;

/**
 * Class RestService
 * @package ACAApiBundle\Services
 */
class RestService {

    /**
     * @var \ACAApiBundle\Services\DBCommon $db
     */
    protected $db;

    /**
     * @param \ACAApiBundle\Services\DBCommon $db
     */
    public function setDb($db)
    {
        /**
         *
         */
        $this->db = $db;
    }

    /**
     * @param $id
     * @return bool|null|\stdClass|\stdClass[]
     */
    public function get($id) {
        if ($id === null) {
            $this->db->setQuery('SELECT lastname, firstname, email FROM user;');
            $this->db->query();
            $objectList = $this->db->loadObjectList();
            if (!is_null($objectList)) {
                return $objectList;
            } else {
                return false;
            }
        } else {
            $this->db->setQuery('SELECT lastname, firstname, email FROM user WHERE id = ' . $id . ';');
            $this->db->query();
            $object = $this->db->loadObject();
            if (!is_null($object)) {
                return $object;
            } else {
                return false;
            }
        }
    }

    /**
     * @param string $tableName
     * @param array $data
     * @return bool
     */
    public function post($tableName, $data) {
        // Construct a query string
        // Expects an associative array
        $query = 'INSERT INTO ' . $tableName . '(';
        foreach ($data as $fieldname => $fieldvalue)
        {
            $query .= $fieldname .',';
        }
        $query = rtrim($query, ',');
        $query .= ') values(';
        foreach ($data as $fieldname => $fieldvalue)
        {
            $query .= '"' . $fieldvalue .'",';
        }
        $query = rtrim($query, ',');
        $query .= ');';

        // Query
        $this->db->setQuery($query);
        $this->db->query();

        // If the query was successful, return true
        if ($this->db->getSqlstate() === '00000') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $tableName
     * @param integer $recordId
     * @param array $data
     * @return bool
     */
    public function put($tableName, $recordId, $data) {
        // Build a query string
        // Expects an associative array
        $query = 'UPDATE ' . $tableName . ' SET ';
        foreach ($data as $fieldname => $fieldvalue)
        {
            $query .= $fieldname .'='. $fieldvalue;
        }
        $query = ' WHERE id=' . $recordId .';';

        // Query
        $this->db->setQuery($query);
        $this->db->query();

        // If the query was successful, return true
        if ($this->db->getSqlstate() === '00000') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $tableName
     * @param integer $recordId
     * @return bool
     */
    public function delete($tableName, $recordId) {
        $this->db->setQuery('DELETE FROM ' .$tableName. ' WHERE id=' .$recordId. ';');
        $this->db->query();

        // If the query was successful, return true
        if ($this->db->getSqlstate() === '00000') {
            return true;
        } else {
            return false;
        }
    }
}