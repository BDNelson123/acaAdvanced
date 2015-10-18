<?php

namespace ACAApiBundle\Model;

/**
 * Class House
 * @package ACAApiBundle\Model\House
 */
class House
{
    protected $house_id;
    protected $address;
    protected $city;
    protected $state;
    protected $zipcode;
    protected $mainimage;
    protected $bednumber;
    protected $bathnumber;
    protected $askingprice;
    protected $extras;


        /**
         * @param $id
         */
        public function __construct($house_id) {
            $this->house_id = $house_id;
        }



    /**
     * Get the value of Class House
     *
     * @return mixed
     */
    public function getHouseId()
    {
        return $this->house_id;
    }

    /**
     * Set the value of Class House
     *
     * @param mixed house_id
     *
     * @return self
     */
    public function setHouseId($house_id)
    {
        $this->house_id = $house_id;

        return $this;
    }

    /**
     * Get the value of Address
     *
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of Address
     *
     * @param mixed address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of City
     *
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of City
     *
     * @param mixed city
     *
     * @return self
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of State
     *
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the value of State
     *
     * @param mixed state
     *
     * @return self
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the value of Zipcode
     *
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set the value of Zipcode
     *
     * @param mixed zipcode
     *
     * @return self
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get the value of Main Image
     *
     * @return mixed
     */
    public function getmainimage()
    {
        return $this->mainimage;
    }

    /**
     * Set the value of Main Image
     *
     * @param mixed mainimage
     *
     * @return self
     */
    public function setmainimage($mainimage)
    {
        $this->mainimage = $mainimage;

        return $this;
    }

    /**
     * Get the value of Bed Number
     *
     * @return mixed
     */
    public function getbednumber()
    {
        return $this->bednumber;
    }

    /**
     * Set the value of Bed Number
     *
     * @param mixed bednumber
     *
     * @return self
     */
    public function setbednumber($bednumber)
    {
        $this->bednumber = $bednumber;

        return $this;
    }

    /**
     * Get the value of Bath Number
     *
     * @return mixed
     */
    public function getBathNumber()
    {
        return $this->bathnumber;
    }

    /**
     * Set the value of Bath Number
     *
     * @param mixed bathnumber
     *
     * @return self
     */
    public function setBathNumber($bathnumber)
    {
        $this->bathnumber = $bathnumber;

        return $this;
    }

    /**
     * Get the value of Asking Price
     *
     * @return mixed
     */
    public function getAskingPrice()
    {
        return $this->askingprice;
    }

    /**
     * Set the value of Asking Price
     *
     * @param mixed askingprice
     *
     * @return self
     */
    public function setAskingPrice($askingprice)
    {
        $this->askingprice = $askingprice;

        return $this;
    }

    /**
     * Get the value of Extras
     *
     * @return mixed
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * Set the value of Extras
     *
     * @param mixed extras
     *
     * @return self
     */
    public function setExtras($extras)
    {
        $this->extras = $extras;

        return $this;
    }

        /**
         * Returns an array of errors for House with any valid field
         * @param $data
         * @return array
         */


}
