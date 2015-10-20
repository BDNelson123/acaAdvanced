<?php

namespace ACAApiBundle\Model;

/**
 * Class House
 * @package ACAApiBundle\Model\House
 */
class House
{
    protected $id;
    protected $address;
    protected $city;
    protected $state;
    protected $zipcode;
    protected $main_image;
    protected $bed_number;
    protected $bath_number;
    protected $asking_price;
    protected $extras;


        /**
         * @param $id
         */
        public function __construct($id) {
            $this->id = $id;
        }



    /**
     * Get the value of Class House
     *
     * @return mixed
     */
    public function getHouseId()
    {
        return $this->id;
    }

    /**
     * Set the value of Class House
     *
     * @param mixed id
     *
     * @return self
     */
    public function setHouseId($id)
    {
        $this->id = $id;

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
    public function getmain_image()
    {
        return $this->main_image;
    }

    /**
     * Set the value of Main Image
     *
     * @param mixed main_image
     *
     * @return self
     */
    public function setmain_image($main_image)
    {
        $this->main_image = $main_image;

        return $this;
    }

    /**
     * Get the value of Bed Number
     *
     * @return mixed
     */
    public function getbed_number()
    {
        return $this->bed_number;
    }

    /**
     * Set the value of Bed Number
     *
     * @param mixed bed_number
     *
     * @return self
     */
    public function setbed_number($bed_number)
    {
        $this->bed_number = $bed_number;

        return $this;
    }

    /**
     * Get the value of Bath Number
     *
     * @return mixed
     */
    public function getbath_number()
    {
        return $this->bath_number;
    }

    /**
     * Set the value of Bath Number
     *
     * @param mixed bath_number
     *
     * @return self
     */
    public function setbath_number($bath_number)
    {
        $this->bath_number = $bath_number;

        return $this;
    }

    /**
     * Get the value of Asking Price
     *
     * @return mixed
     */
    public function getasking_price()
    {
        return $this->asking_price;
    }

    /**
     * Set the value of Asking Price
     *
     * @param mixed asking_price
     *
     * @return self
     */
    public function setasking_price($asking_price)
    {
        $this->asking_price = $asking_price;

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
