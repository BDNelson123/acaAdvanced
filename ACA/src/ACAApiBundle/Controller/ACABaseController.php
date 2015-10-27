<?php

namespace ACAApiBundle\Controller;

use ACAApiBundle\Entity\ACABaseEntity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class ACABaseController
 * @package ACAApiBundle\Controller
 */
class ACABaseController extends Controller
{
    /**
     * Get all data for all items in a particular table.
     * @return Response|JsonResponse
     */
    public function getPaginatedResults($name)
    {
        $response = new JsonResponse();
        $items = $this->getDoctrine()
            ->getRepository('ACAApiBundle:' . $name . 'Entity')
            ->findAll();

        // responses per page (for pagination)
        if(isset($_GET['rpp'])) {
            $rpp = $_GET['rpp'];
        } else {
            $rpp = 5;
        }

        if (!$items) {
            $response->setStatusCode(400)
                ->setData(array(
                    'message' => 'Index request found no records'
                ));
            return $response;
        }

        $responseSetData = [];
        foreach($items as $item){
            $responseSetData[] = $item->getData();
        }

        // At this point, $responseSetData is an array and can be used with the paginator
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $responseSetData,
            $this->get('request')->query->get('page', 1),
            $rpp
        );

        $paginated_results = $pagination->getItems();

        $response->setData($paginated_results);
        return $response;
    }
}


?>