<?php

namespace ACAApiBundle\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use \DateTime;

/**
 * Class Bid
 * @package ACAApiBundle\Model\Bid
 */
class Bid
{
    /**
     * @var $id integer
     */
    protected $id;

    /**
     * @var $userid integer
     * @Assert\NotBlank()
     */
    protected $userid;

    /**
     * @var $houseid integer
     * @Assert\NotBlank()
     */
    protected $houseid;

    /**
     * @var $bidamount integer
     * @Assert\Range(
     *      min = 1000,
     *      max = 999999999,
     *      minMessage = "Please enter a bid of at least ${{ limit }}.",
     *      maxMessage = "Please be realistic with your bid.",
     * )
     */
    protected $bidamount;

    /**
     * @var $biddate datetime
     * @Assert\DateTime()
     */
    protected $biddate;

    /**
     * @param $id
     */
    public function __construct($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserId($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return mixed
     */
    public function gethouseid()
    {
        return $this->houseid;
    }

    /**
     * @param mixed $houseid
     */
    public function setHouseId($houseid)
    {
        $this->houseid = $houseid;
    }

    /**
     * @return mixed
     */
    public function getBidAmount()
    {
        return $this->bidamount;
    }

    /**
     * @param mixed $bidamount
     */
    public function setBidAmount($bidamount)
    {
        $this->bidamount = $bidamount;
    }

    /**
     * @return mixed
     */
    public function getBidDate()
    {
        return $this->biddate;
    }

    /**
     * @param mixed $biddate
     */
    public function setBidDate($biddate)
    {
        $this->biddate = $biddate;
    }

    /**
     * Validates a Bid with all required fields
     * @param Request $request
     * @return bool|array
     */
    public static function validatePost(Request $request) {
        $data = Bid::getDataFromRequest($request);

        // If it's missing needed fields ...
        if (empty($data['userid']) || empty($data['houseid']) || empty($data['bidamount'])) {
            return false;
        }

        return $data;
    }

    /**
     * Validates a Bid with any valid field
     * @param Request $request
     * @return bool|array
     */
    public static function validatePut(Request $request) {
        $data = Bid::getDataFromRequest($request);

        // If it's missing needed fields ...
        if (empty($data['userid']) && empty($data['houseid']) &&
            empty($data['bidamount']) && empty($data['biddate'])) {
            return false;
        }

        return $data;
    }

    /**
     * Gets an associative array out of a valid Json
     * @param Request $request
     * @return bool|array
     */
    private static function getDataFromRequest(Request $request) {
        $data = json_decode($request->getContent(), true);

        // If the output of json_decode is not an array ...
        if (gettype($data) !== 'array') { return false; }

        // Passed all checks, return the contents of the request
        return $data;
    }
}