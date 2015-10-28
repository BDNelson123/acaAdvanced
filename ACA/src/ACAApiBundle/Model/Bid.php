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
     * @var $user_id integer
     * @Assert\NotBlank()
     */
    protected $user_id;

    /**
     * @var $house_id integer
     * @Assert\NotBlank()
     */
    protected $house_id;

    /**
     * @var $bid_amount integer
     * @Assert\Range(
     *      min = 1000,
     *      max = 999999999,
     *      minMessage = "Please enter a bid of at least ${{ limit }}.",
     *      maxMessage = "Please be realistic with your bid.",
     * )
     */
    protected $bid_amount;

    /**
     * @var $bid_date datetime
     * @Assert\DateTime()
     */
    protected $bid_date;

    /**
     * @param $id
     */
    public function __construct($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getuser_id()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setuser_id($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function gethouse_id()
    {
        return $this->house_id;
    }

    /**
     * @param mixed $house_id
     */
    public function sethouse_id($house_id)
    {
        $this->house_id = $house_id;
    }

    /**
     * @return mixed
     */
    public function getbid_amount()
    {
        return $this->bid_amount;
    }

    /**
     * @param mixed $bid_amount
     */
    public function setbid_amount($bid_amount)
    {
        $this->bid_amount = $bid_amount;
    }

    /**
     * @return mixed
     */
    public function getbid_date()
    {
        return $this->bid_date;
    }

    /**
     * @param mixed $bid_date
     */
    public function setbid_date($bid_date)
    {
        $this->bid_date = $bid_date;
    }



    /**
     * Validates a Bid with all required fields
     * @param Request $request
     * @return bool|array
     */
    public static function validatePost(Request $request) {
        $data = Bid::getDataFromRequest($request);

        // If it's missing needed fields ...
        if (empty($data['user_id']) || empty($data['house_id']) || empty($data['bid_amount'])) {
            return false;
        }

        // Make sure the bid amount is something within a realistic range.
        if ($data['bid_amount'] < 1000 || $data['bid_amount'] > 999999999) {
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
        if (empty($data['user_id']) && empty($data['house_id']) &&
            empty($data['bid_amount'])) {
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
