<?php

# GET, PUT, SHOW, POST, DELETE

namespace ACAApiBundle\Controller;

use ACAApiBundle\Entity\HouseImageEntity;
use ACAApiBundle\Services\DBCommon;
use ACAApiBundle\Model\HouseImage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
/**
 * Class HouseImageController
 * @package ACAApiBundle\Controller
 */
class HouseImageController extends Controller
{

    /**
     * Get all data for all HouseImages in the HouseImage table.
     * @return Response|JsonResponse
     */
    public function getAction()
    {
        $response = new JsonResponse();
        $house_images = $this->getDoctrine()
            ->getRepository('ACAApiBundle:HouseImageEntity')
            ->findAll();

        if (!$house_images) {
            $response->setStatusCode(400)
                ->setData(array(
                  'message' => 'Index request found no records'
                ));
            return $response;
        }

        $responseSetData = [];
        foreach($house_images as $house_image){
            $responseSetData[] = $house_image->getData();
        }

        $response->setData($responseSetData);
        return $response;
    }


    /**
     * Find and show a particular HouseImage in the HouseImage table, based on id (slug).
     * @param $slug
     * @return Response|JsonResponse
     */
    public function showAction($slug)
    {
        $response = new JsonResponse();
        $house_image = $this->getDoctrine()
            ->getRepository('ACAApiBundle:HouseImageEntity')
            ->find($slug);

        if (!$house_image) {
            $response->setStatusCode(400)->setData(array(
              'message' => 'No record found for id ' . $slug
            ));
            return $response;
        }

        $response->setData($house_image->getData());
        return $response;
    }

    /**
     * Add a HouseImage to the HouseImage table.
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function postAction(Request $request)
    {
      $response = new JsonResponse();
      $data = json_decode($request->getContent(), true);
      $errors = $this->houseImageErrors($data);

      if($errors) {
        $response->setStatusCode(400)->setData($errors);
        return $response;
    }

        $em = $this->getDoctrine()->getManager();
        $house_image = new HouseImageEntity();
        $house_image->setData($data);
        $em->persist($house_image);
        $em->flush();

        $response->setStatusCode(200)->setData(array(
            'message' => 'Successfully posted new house image.',
            'id' => $house_image->getId()
            )
        );

        return $response;
    }


    /**
     * Update a particular HouseImage in the HouseImage table, based on id (slug).
     * @param $slug
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function putAction($slug, Request $request)
    {
      $response = new JsonResponse();
      $data = json_decode($request->getContent(), true);
      $errors = $this->houseImageErrors($data);

      if($errors) {
        $response->setStatusCode(400)->setData($errors);
        return $response;
      }

      $em = $this->getDoctrine()->getManager();
      $house_image = $this->getDoctrine()
          ->getRepository('ACAApiBundle:HouseImageEntity')
          ->find($slug);
      $house_image->setData($data);
      $em->persist($house_image);
      $em->flush();

      $response->setStatusCode(200)->setData(array(
          'message' => 'Successfully updated house image',
          'id' => $bid->getId()
          )
      );
      return $response;
    }

    /**
     * Delete a particular HouseImage already in the HouseImage table.
     * @param $slug
     * @return Response|JsonResponse
     */
    public function deleteAction($slug) {
        $response = new JsonResponse();
        $house_image = $this->getDoctrine()
            ->getRepository('ACAApiBundle:HouseImageEntity')
            ->find($slug);

        if (!$house_image) {
            $response->setStatusCode(400)->setData(array(
              'message' => 'No record found for id ' . $slug
              ));
            return $response;
        };

        $em = $this->getDoctrine()->getManager();
        $em->remove($house_image);
        $em->flush();

        $response->setStatusCode(200)->setData(array(
          'message' => 'Successfully deleted house image ' . $slug
          ));
        return $response;
    }


    /**
     * @param Request $request
     * @return array
     * Returns an array of errors (or an empty array) based on user input for a house_image.
     */
    public function houseImageErrors($data)
    {
        $houseErrors = [];

          // checks the house_id from the inputed data
          if (empty($data['house_id'])) {
          array_push( $houseErrors, array(
              'house_id_empty' => 'The image does not have a house associated with it.'
          ));} elseif (!preg_match("/^[0-9]+$/", $data['house_id'])) {
          array_push( $houseErrors, array(
              'house_id_entry' => 'The house id is not correct.'
          ));};

          //checks the address from the inputed data
          if (empty($data['house_image'])) {
          array_push( $houseErrors, array(
              'house_image_empty' => 'The image is not filled in.'
          ));} elseif (!preg_match("/^[0-9a-zA-Z\,\s]+$/", $data['house_image'])) {
          array_push( $houseErrors, array(
              'address_check_entry' => 'The image is not the right format.'
          ));};

        return $houseErrors;
    }
}
