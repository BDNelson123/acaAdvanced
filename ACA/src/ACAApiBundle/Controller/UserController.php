<?php

namespace ACAApiBundle\Controller;

use ACAApiBundle\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package ACAApiBundle\Controller
 *
 */
class UserController extends Controller
{
    /**
     * @return Response|JsonResponse
     */
    public function getAction()
    {
        $data = $this->get('rest_service')->get('user');
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
     * @return Response|JsonResponse
     */
    public function showAction($slug)
    {
        $data = $this->get('rest_service')->get('user', $slug);
        if ($data) {
            $response = new JsonResponse();
            $response->setData($data);
        } else {
            $response = new Response;
            $response->setStatusCode(500)->setContent('No record ' .$slug. ' found');
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
        $data = User::validatePost($request);
        if (gettype($data) === 'array') {
              if ($this->get('rest_service')->post('user', $data))
              {
                  $response->setStatusCode(200)->setContent('Posted new record to /user');
              } else {
                  $response->setStatusCode(500)->setContent('Request failed; internal server error');
              }
        } else {
            $response->setStatusCode(400)->setContent('Invalid request; ' .$data);
        }
        return $response;
    }

    /**
     * @param $slug
     * @param Request $request
     * @return Response
     */
    public function putAction($slug, Request $request) {
        $response = new Response();
        $data = User::validatePut($request);
        if (gettype($data) === 'array') {
            if ($this->get('rest_service')->put('user', $slug, $data))
            {
                $response->setStatusCode(200)->setContent('Succesfully updated record ' .$slug);
            } else {
                $response->setStatusCode(500)->setContent('Request failed; internal server error');
            }
        } else {
            $response->setStatusCode(400)->setContent('Invalid request; ' .$data);
        }
        return $response;
    }

    /**
     * @param $slug
     * @return Response
     */
    public function deleteAction($slug)
    {
        $response = new Response();
        if ($this->get('rest_service')->delete('user', $slug)) {
            $response->setStatusCode(200)->setContent('Successfully deleted record ' . $slug);
        } else {
            $response->setStatusCode(500)->setContent('No record ' .$slug. ' found');
        }
        return $response;
    }
}
