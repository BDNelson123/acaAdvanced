<?php

namespace ACAApiBundle\Controller;

use ACAApiBundle\Services\DBCommon;
use ACAApiBundle\Model\House;
use ACAApiBundle\Entity\HouseEntity;
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
       * This action will get all the data for houses from the database.
       */
      public function getAction()
      {
          $response = new JsonResponse();
          $houses = $this->getDoctrine()
              ->getRepository('ACAApiBundle:HouseEntity')
              ->findAll();

          // responses per page (for pagination)
          $rpp = 5;

          if (!$houses) {
              $response->setStatusCode(400)
                  ->setData(array(
                    'message' => 'Index request found no records'
                  ));
              return $response;
          }

          $responseSetData = [];
          foreach($houses as $house){
              $responseSetData[] = $house->getData();
          };

          // At this point, $responseSetData is an array of bids and can be used with the paginator
          $paginator  = $this->get('knp_paginator');
          $pagination = $paginator->paginate(
              $responseSetData,
              $this->get('request')->query->get('page', 1),
              $rpp
          );
          $items = $pagination->getItems();

          $response->setData($items);
          return $response;
      }


      /**
       * @param $slug
       * @return Response\JsonResponse
       * This action will find a particular house from the database.
       */
      public function showAction($slug)
      {
          $response = new JsonResponse();

          $house = $this->getDoctrine()
              ->getRepository('ACAApiBundle:HouseEntity')
              ->find($slug);

          if (!$house) {
              $response->setStatusCode(400)->setData(array(
                'message' => 'No record found'
              ));
              return $response;
          }

          $response->setData($house->getData());
          return $response;
      }

      /**
       * @param Request $request
       * @return Response\JsonResponse
       * This action will add a particular house to the database.
       */
      public function postAction(Request $request)
      {
          $response = new JsonResponse();
          $data = json_decode($request->getContent(), true);
          $errors = $this->houseErrors($data);

          if($errors) {
            $response->setStatusCode(400)->setData($errors);
            return $response;
        }

              $em = $this->getDoctrine()->getManager();
              $house = new HouseEntity();
              $house->setData($data);
              $em->persist($house);
              $em->flush();

              $db = $this->get('db');
              $response->setStatusCode(200)->setData(array(
                  'message' => 'Successfully posted new record',
                  'id' => $db->getLastInsertId()
                  )
              );
          return $response;
      }


      /**
       * @param $slug
       * @param Request $request
       * @return Response
       * This action will update a particular house already in the database.
       */
      public function putAction($slug, Request $request)
      {
        $response = new JsonResponse();
        $data = json_decode($request->getContent(), true);
        $errors = $this->houseErrors($data);

        if($errors) {
          $response->setStatusCode(400)->setData($errors);
          return $response;
      }

            $em = $this->getDoctrine()->getManager();
            $house = $this->getDoctrine()
                ->getRepository('ACAApiBundle:HouseEntity')
                ->find($slug);
            $house->setData($data);
            $em->persist($house);
            $em->flush();

            $db = $this->get('db');
            $response->setStatusCode(200)->setData(array(
                'message' => 'Successfully posted new record',
                'id' => $db->getLastInsertId()
                ));
        return $response;
      }

      /**
       * @param $slug
       * @return Response
       * This action will delete a particular house already in the database.
       */
      public function deleteAction($slug) {
          $response = new JsonResponse();

          $house = $this->getDoctrine()
              ->getRepository('ACAApiBundle:HouseEntity')
              ->find($slug);

          if (!$house) {
              $response->setStatusCode(400)->setData(array(
                'message' => 'No record found'
                ));
              return $response;
          };

          $em = $this->getDoctrine()->getManager();
          $em->remove($house);
          $em->flush();

          $response->setStatusCode(200)->setData(array(
            'message' => 'Successfully deleted record ' . $slug
            ));
          return $response;
      }



      public static function houseErrors($data)
      {
        $houseErrors = array();

          //checks the address from the inputed data
          if (empty($data['address'])) {
          array_push( $houseErrors, array(
              'address_empty' => 'The address is not filled in.'
          ));} elseif (!preg_match("/^[0-9a-zA-Z\,\s]+$/", $data['address'])) {
          array_push( $houseErrors, array(
              'address_check_entry' => 'The address is not correct and must be only letters and numbers.'
          ));};

          //checks the city from the inputed data
          if (empty($data['city'])) {
          array_push( $houseErrors, array(
              'city_empty' => 'The city is not filled in.'
          ));} elseif (!preg_match("/^[a-zA-Z\,\s]+$/", $data['city'])) {
          array_push( $houseErrors, array(
              'city_check_entry' => 'The city is not correct and must be only letters.'
          ));};

          //checks the state from the inputed data
          if (empty($data['state'])) {
          array_push( $houseErrors, array(
              'state_empty' => 'The state is not filled in.'
          ));} elseif (!preg_match("/^[a-zA-Z]+$/", $data['state'])) {
          array_push( $houseErrors, array(
              'state_check_entry' => 'The state is not correct and must be letters.'
          ));};

          //checks the zipcode from the inputed data
          if (empty($data['zipcode'])) {
          array_push( $houseErrors, array(
              'zipcode_empty' => 'The zipcode is not filled in.'
          ));} elseif (!preg_match("/^[0-9]{5}$/", $data['zipcode'])) {
          array_push( $houseErrors, array(
              'zipcode_check_entry' => 'The zipcode is not correct and must be five numbers.'
          ));};

          if (empty($data['main_image'])) {
          array_push( $houseErrors, array(
              'main_image_empty' => 'The main image is not filled in.'
          ));} elseif (!preg_match("/^[0-9a-zA-Z\,\s]+$/", $data['main_image'])) {
          array_push( $houseErrors, array(
              'main_image_check_entry' => 'The main image is not correct and must be only letters and numbers.'
          ));};

        //  //checks the main_image from the inputed data
        //  if (empty($data['main_image'])) {
        //  array_push( $houseErrors, array('main_image_empty' => 'The main image is not filled in.'
        //  ));} elseif (filter_var($data['main_image'], FILTER_VALIDATE_URL) == false) {
        //  array_push( $houseErrors, array('main_image_check_entry' => 'The main image is not correct and must be a url.'
        //  ));};

          //checks the bed_number from the inputed data
          if (empty($data['bed_number'])) {
          array_push( $houseErrors, array(
              'bed_number_empty' => 'The bed number is not filled in.'
          ));} elseif (!preg_match("/^[0-9\\.]{3}$/", $data['bed_number'])) {
          array_push( $houseErrors, array(
              'bed_number_check_entry' => 'The bed number is not correct and must only be 3 numbers.'
          ));};

          //checks the bath_number from the inputed data
          if (empty($data['bath_number'])) {
          array_push( $houseErrors, array(
              'bath_number_empty' => 'The bath number is not filled in.'
          ));} elseif (!preg_match("/^[0-9\\.]{3}$/", $data['bath_number'])) {
          array_push( $houseErrors, array(
              'bath_number_check_entry' => 'The bath number is not correct and must only be 3 numbers.'
          ));};

          //checks the asking_price from the inputed data
          if (empty($data['asking_price'])) {
          array_push( $houseErrors, array(
              'asking_price_empty' => 'The asking price is not filled in.'
          ));} elseif (!preg_match("/^[0-9\\,]+$/", $data['asking_price'])) {
          array_push( $houseErrors, array(
              'asking_price_check_entry' => 'The asking price is not correct and must only be numbers.'
          ));} elseif (strlen($data['asking_price']) >= 10 ) {
          array_push( $houseErrors, array(
              'asking_price_check_length_over' => 'The asking price is not correct and must under $99,999,999.'
          ));};

          //checks the extras from the inputed data
          if (empty($data['extras'])) {
          array_push( $houseErrors, array(
              'extras_empty' => 'The extras is not filled in.'
          ));} elseif (!preg_match("/^[a-z0-9 .\-]+$/i", $data['extras'])) {
          array_push( $houseErrors, array(
              'extras_check_entry' => 'The extras is not correct and must be normal sentences.'
         ));};

              return $houseErrors;
          }
}
