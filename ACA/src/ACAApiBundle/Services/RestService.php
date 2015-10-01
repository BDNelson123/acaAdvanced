<?php

namespace ACAApiBundle\Services;

use ACAApiBundle\Services\DBCommon;

class RestService {

    /**
     * @var DBCommon
     */
    protected $db;

    /**
     * @param \ACAApiBundle\Services\DBCommon $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

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
        };
    }

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
        };
    }

    public function delete($tableName, $recordId) {
        $this->db->setQuery('DELETE FROM ' .$tableName. ' WHERE id=' .$recordId. ';');
        $this->db->query();
        // If the query was successful, return true
        if ($this->db->getSqlstate() === '00000') {
            return true;
        } else {
            return false;
        };
    }
}