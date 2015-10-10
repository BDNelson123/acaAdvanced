<?php

namespace ACAApiBundle\Controller;

use ACAApiBundle\Services\DBCommon;
use ACAApiBundle\Model\House;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HouseController
 * @package ACAApiBundle\Controller
 *
 */
class HouseController extends Controller
{
    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function getAction()
    {
        /**
         * @var DBCommon
         */
        $db = $this->get('db');
        $db->setQuery('SELECT * FROM house;');
        $db->query();
        $ObjectList = $db->loadObjectList();
        $response = new JsonResponse();
        $response->setData($db->loadObjectList());
        return $response;
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws \Exception
     */
    public function showAction($slug)
    {
        /**
         * @var $db DBCommon
         */
        $db = $this->get('db');
        $db->setQuery('SELECT address, city, state, zipcode, main_image, bed_number, bath_number, asking_price, extras FROM house WHERE house_id = ' . $slug . ';');
        $db->query();
        $response = new JsonResponse();
        $response->setData($db->loadObjectList());
        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function postAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $address = $data['address'];
        $city = $data['city'];
        $state = $data['state'];
        $zipcode = $data['zipcode'];
        $main_image = $data['main_image'];
        $bed_number = $data['bed_number'];
        // $bath_number = $data['bath_number'];
        $asking_price = $data['asking_price'];
        $extras = $data['extras'];


        $Errors = $this->houseErrors($data);

        if(empty($Errors)){

          $db = $this->get('db');
          $db->setQuery('INSERT INTO house (address, city, state, zipcode, main_image, bed_number, asking_price, extras)
          VALUES("'.$address.'", "'.$city.'", "'.$state.'", "'.$zipcode.'", "'.$main_image.'", "'.$bed_number.'", "'.$asking_price.'", "'.$extras.'");');
          $db->query();

          $response = new JsonResponse();
          $response->setData(array(
              'status' => $db->getErrorString(),
              'Inserted record with ID' => $db->getLastInsertId()
          ));

        return $response;

        } else {

         $response = new JsonResponse();
         $response->setData(
              $Errors
         );

          return $response;

        };
    }


    public static function houseErrors($data)
    {

        $houseErrors = array();

        //checks the address from the inputed data
        if (empty($data['address'])) {

           array_push( $houseErrors, array('address_empty' => 'The address is not filled in.'));

        } elseif (!preg_match("/^[0-9a-zA-Z\,\s]+$/", $data['address'])) {

           array_push( $houseErrors, array('address_check_entry' => 'The address is not correct and must be only letters and numbers.'));

        };


        //checks the city from the inputed data
        if (empty($data['city'])) {

           array_push( $houseErrors, array('city_empty' => 'The city is not filled in.'));

        } elseif (!preg_match("/^[a-zA-Z\,\s]+$/", $data['city'])) {

           array_push( $houseErrors, array('city_check_entry' => 'The city is not correct and must be only letters.'));

        };


        //checks the state from the inputed data
        if (empty($data['state'])) {

           array_push( $houseErrors, array('state_empty' => 'The state is not filled in.'));

        } elseif (!preg_match("/^[a-zA-Z]+$/", $data['state'])) {

           array_push( $houseErrors, array('state_check_entry' => 'The state is not correct and must be letters.'));

        };


        //checks the zipcode from the inputed data
        if (empty($data['zipcode'])) {

           array_push( $houseErrors, array('zipcode_empty' => 'The zipcode is not filled in.'));

        } elseif (!preg_match("/^[0-9]{5}+$/", $data['zipcode'])) {

           array_push( $houseErrors, array('zipcode_check_entry' => 'The zipcode is not correct and must be five numbers.'));
        //
        // } elseif (strlen($data['zipcode']) != 5) {
        //
        //    array_push( $houseErrors, array('zipcode_check_length' => 'The zipcode is not correct and must be under 5 numbers.'));
        //
        };


        //checks the main_image from the inputed data
        if (empty($data['main_image'])) {

           array_push( $houseErrors, array('main_image_empty' => 'The main image is not filled in.'));

        } elseif (filter_var($data['main_image'], FILTER_VALIDATE_URL) == false) {

           array_push( $houseErrors, array('main_image_check_entry' => 'The main image is not correct and must be a url.'));

        };


        //checks the bed_number from the inputed data
        if (empty($data['bed_number'])) {

           array_push( $houseErrors, array('bed_number_empty' => 'The bed number is not filled in.'));

        } elseif (!preg_match("/^[0-9\\.]{3}+$/", $data['bed_number'])) {

           array_push( $houseErrors, array('bed_number_check_entry' => 'The bed number is not correct and must only be 3 numbers.'));
        //
        // } elseif (strlen($data['bed_number']) != 3) {
        //
        //    array_push( $houseErrors, array('bed_number_check_length_over' => 'The bed number is not correct and must only be 3 numbers.'));

        };

        //checks the asking_price from the inputed data
        if (empty($data['asking_price'])) {

           array_push( $houseErrors, array('asking_price_empty' => 'The asking price is not filled in.'));

        } elseif (!preg_match("/^[0-9\\,]+$/", $data['asking_price'])) {

           array_push( $houseErrors, array('asking_price_check_entry' => 'The asking price is not correct and must only be numbers.'));

        } elseif (strlen($data['asking_price']) >= 10 ) {

           array_push( $houseErrors, array('asking_price_check_length_over' => 'The asking price is not correct and must under $99,999,999.'));

        };

        //checks the extras from the inputed data
        if (empty($data['extras'])) {

           array_push( $houseErrors, array('extras_empty' => 'The extras is not filled in.'));

        } elseif (!preg_match("/^[a-z0-9 .\-]+$/i", $data['extras'])) {

           array_push( $houseErrors, array('extras_check_entry' => 'The extras is not correct and must be normal sentences.'));

        };









        return $houseErrors;
    }

    /**
     * @param $slug
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function putAction($slug, Request $request) {

        $data = json_decode($request->getContent(), true);
        $address = $data['address'];
        $city = $data['city'];
        $state = $data['state'];
        $zipcode = $data['zipcode'];
        $main_image = $data['main_image'];
        $bed_number = $data['bed_number'];
        $bath_number = $data['bath_number'];
        $asking_price = $data['asking_price'];
        $extras = $data['extras'];

        $Errors = $this->houseErrors($data);

        if(empty($Errors)){

          $db = $this->get('db');
          $db->setQuery('UPDATE house SET adrress="'.$address.'", city="'.$city.'", state="'.$state.'", zipcode="'.$zipcode.'", main_image="'.$main_image.'", bed_number="'.$bed_number.'", bath_number="'.$bath_number.'", asking_price="'.$asking_price.'", extras="'.$extras.'" WHERE house_id='.$slug.';');
          $db->query();

          $response = new JsonResponse();
          $response->setStatusCode(200);

        return $response;

        } else {

         $response = new JsonResponse();
         $response->setData(
              $Errors
         );

          return $response;

        };
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteAction($slug) {
        $db = $this->get('db');
        $db->setQuery('DELETE FROM house WHERE house_id='.$slug.';');
        $db->query();
        $response = new Response();
        $response->setStatusCode(200);
        return $response;
    }
}
