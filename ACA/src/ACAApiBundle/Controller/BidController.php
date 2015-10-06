<?php

# GET, PUT, SHOW, POST, DELETE

namespace ACAApiBundle\Controller;

use ACAApiBundle\Model\Bid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BidController
 * @package ACAApiBundle\Controller
 */
class BidController extends Controller
{
    /**
     * @return Response\JsonResponse
     */
    public function getAction()
    {
        $data = $this->get('rest_service')->get('bid');
        if ($data) {
            $response = new JsonResponse();
            $response->setData($data);
        } else {
            $response = new Response;
            $response->setStatusCode(500)->setContent('Index request found no records');
        }
        return $response;
    }

    /**
     * @param $slug
     * @return Response\JsonResponse
     */
    public function showAction($slug)
    {
        $data = $this->get('rest_service')->get('bid', $slug);
        if ($data) {
            $response = new JsonResponse();
            $response->setData($data);
        } else {
            $response = new Response;
            $response->setStatusCode(500)->setContent('No record found');
        }
        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postAction(Request $request)
    {
        $response = new Response;
        $data = Bid::validatePost($request);
        if ($data) {
            if ($this->get('rest_service')->post('bid', $data))
            {
                $response->setStatusCode(200)->setContent('Posted new record to /bid');
            } else { $response->setStatusCode(500)->setContent('Query failed');
                // ... whoops, bad SQL query
            }
        } else {
            $response->setStatusCode(400)->setContent('Invalid request; expected Json with fields "userid", "houseid", "bidamount"');
            // ... the request didn't validate so $data was false
        }
        return $response;
    }

    /**
     * @param $slug
     * @param Request $request
     * @return Response
     */
    public function putAction($slug, Request $request)
    {
        $response = new Response();
        $data = Bid::validatePut($request);
        if ($data) {
            if ($this->get('rest_service')->put('bid', $slug, $data))
            {
                $response->setStatusCode(200)->setContent('Succesfully updated record ' .$slug);
            } else {
                $response->setStatusCode(500)->setContent('Query failed');
            }
        } else {
            $response->setStatusCode(403)->setContent('Invalid request; expected Json with fields "userid", "houseid", "bidamount", "biddate"');
        }
        return $response;
    }

    /**
     * @param $slug
     * @return Response
     */
    public function deleteAction($slug) {
        $response = new Response();
        if ($this->get('rest_service')->delete('bid', $slug)) {
            $response->setStatusCode(200)->setContent('Successfully deleted record ' . $slug);
        } else {
            $response->setStatusCode(500)->setContent('Query failed');
        }
        return $response;

        // Not working as of 10/05/15 -- Case mismatch between loaded and declared class names: ACAApiBundle\Controller\bidController vs ACAApiBundle\Controller\BidController
    }
}