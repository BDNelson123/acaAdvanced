<?php

namespace ACAApiBundle\Services;

use ACAApiBundle\Services\DBCommon;

/**
 * Class RestService
 * @package ACAApiBundle\Services
 *
 * All methods return either a boolean representing success/failure or, in the event
 * of a successful get, a standard object. Post and put expect an associative array
 * in the $data parameter.
 *
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
         * @var DBCommon $db
         */
        $this->db = $db;
    }

    /**
     * @param string $tableName
     * @param null|integer $id
     * @return bool|null|\stdClass|\stdClass[]
     */
    public function get($tableName, $id = null) {
        if ($id === null) {
            $this->db->setQuery('SELECT * FROM ' .$tableName.';');
            $this->db->query();
            if ($this->db->getSqlstate() === '00000') {
                return $this->db->loadObjectList();
            } else {
                return false;
            }
        } else {
            $this->db->setQuery('SELECT * FROM ' .$tableName. ' WHERE id = ' . $this->sanitize($id) . ';');
            $this->db->query();
            if ($this->db->getSqlstate() === '00000') {
                return $this->db->loadObject();
            } else {
                return false;
            }
        }
    }

    /**
     * @param string $tableName
     * @param array $data $data Expects an associative array, e.g. json_decode({$request->getContent()}, true)
     * @return bool
     */
    public function post($tableName, $data) {
        // Construct a query string
        // Expects an associative array
        $query = 'INSERT INTO ' . $tableName . '(';
        foreach ($data as $fieldname => $fieldvalue)
        {
            $query .= $this->sanitize($fieldname) .',';
        }
        $query = rtrim($query, ',');
        $query .= ') values(';
        foreach ($data as $fieldname => $fieldvalue)
        {
            $query .= '"' . $this->sanitize($fieldvalue) .'",';
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
     * @param array $data Expects an associative array, e.g. json_decode({$request->getContent()}, true)
     * @return bool
     */
    public function put($tableName, $recordId, $data) {
        // Build a query string
        // Expects an associative array
        $query = 'UPDATE ' . $tableName . ' SET ';
        foreach ($data as $fieldname => $fieldvalue)
        {
            $query .=  $this->sanitize($fieldname) .'="'. $this->sanitize($fieldvalue) . '",';
        }
        $query = rtrim($query, ',');
        $query .= ' WHERE id=' . $recordId .';';

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
     *
     * @return bool
     */
    public function delete($tableName, $recordId) {
        $this->db->setQuery('DELETE FROM ' .$tableName. ' WHERE id=' .$this->sanitize($recordId). ';');
        $this->db->query();

        // If the query was successful, return true
        if ($this->db->getSqlstate() === '00000') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $string
     * @return string
     */
    private function sanitize($string) {
        return str_replace(array('*',',','\\',';'), '', $string);
    }
}