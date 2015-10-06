<?php

namespace ACAApiBundle\Controller;

use ACAApiBundle\DBCommon;
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
         * @var $db DBCommon
         */
        $db = $this->get('db');
        $db->setQuery('SELECT address, city, state, zipcode, main_image, bed_number, bath_number, asking_price, extras FROM house;');
        $db->query();
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
        $asking_price = $data['asking_price'];
        $extras = $data['extras'];
        $bath_number = $data['bath_number'];
        $db = $this->get('db');
        $db->setQuery('INSERT INTO house (address, city, state, zipcode, main_image, bed_number, asking_price, extras, bath_number)
        VALUES("'.$address.'", "'.$city.'", "'.$state.'", "'.$zipcode.'", "'.$main_image.'", "'.$bed_number.'", "'.$asking_price.'", "'.$extras.'", "'.$bath_number.'");');
        $db->query();
        $response = new JsonResponse();
        $response->setData(array(
            'Inserted record with ID' => $db->getLastInsertId()
        ));
        return $response;
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
        $asking_price = $data['asking_price'];
        $extras = $data['extras'];
        $bath_number = $data['bath_number'];
        $db = $this->get('db');
        $db->setQuery('UPDATE house SET adrress="'.$address.'", city="'.$city.'", state="'.$state.'", zipcode="'.$zipcode.'", main_image="'.$main_image.'", bed_number="'.$bed_number.'", asking_price="'.$asking_price.'", extras="'.$extras.'", bath_number="'.$bath_number.'" WHERE house_id='.$slug.';');
        $db->query();
        $response = new Response();
        $response->setStatusCode(200);
        return $response;
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
