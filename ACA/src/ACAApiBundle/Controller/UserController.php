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
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function getAction(Request $request)
    {
        $auth = $this->get('auth_service')->authenticateRequest($request);
        if ($auth != true) {
            return new Response('Authentication failed; ' .$auth, 403);
        }

        $data = $this->get('rest_service')->get('user');
        if ($data) {
            return new JsonResponse(User::cleanupForDisplay($data), 200);
        } else {
            return new Response('Index request found no records', 200);
        }
    }

    /**
     * @param $slug
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function showAction($slug, Request $request)
    {
        $auth = $this->get('auth_service')->authenticateRequest($request);
        if ($auth != true) {
            return new Response('Authentication failed; ' .$auth, 403);
        }

        $data = $this->get('rest_service')->get('user', $slug);
        if ($data) {
            return new JsonResponse(User::cleanupForDisplay($data), 200);
        } else {
            return new Response('No record ' .$slug. ' found', 200);
        }
    }

    /**
     * In practice this will be used to register new users
     * @param Request $request
     * @return Response
     */
    public function postAction(Request $request)
    {
        $auth = $this->get('auth_service')->authenticateRequest($request);
        if ($auth != true) {
            return new Response('Authentication failed; ' .$auth, 403);
        }

        $data = User::validatePost($request);
        if (gettype($data) === 'array') {
            $data['password'] = $this->container->get('security.password_encoder')->encodePassword(new User, $data['password']);
            if ($this->get('rest_service')->post('user', $data)) {
                return new Response('Posted new record to /user', 200);
            } else {
                return new Response('Request failed; internal server error', 500);
            }
        } else {
            return new Response('Invalid request; ' .$data, 400);
        }
    }

    /**
     * @param $slug
     * @param Request $request
     * @return Response
     */
    public function putAction($slug, Request $request)
    {
        $auth = $this->get('auth_service')->authenticateRequest($request);
        if ($auth != true) {
            return new Response('Authentication failed; ' .$auth, 403);
        }

        $data = User::validatePut($request);
        if (gettype($data) === 'array') {
            if (!empty($data['password'])) {
                $data['password'] = $this->container->get('security.password_encoder')->encodePassword(new User, $data['password']);
            }
            if ($this->get('rest_service')->put('user', $slug, $data)) {
                return new Response('Succesfully updated record ' .$slug, 200);
            } else {
                return new Response('Request failed; internal server error', 500);
            }
        } else {
            return new Response('Invalid request; ' .$data, 400);
        }
    }

    /**
     * @param Request $request
     * @param $slug
     * @return Response
     */
    public function deleteAction($slug, Request $request)
    {
        $auth = $this->get('auth_service')->authenticateRequest($request);
        if ($auth != true) {
            return new Response('Authentication failed; ' .$auth, 403);
        }

        if ($this->get('rest_service')->delete('user', $slug)) {
            return new Response('Successfully deleted record ' . $slug, 200);
        } else {
            return new Response('No record ' .$slug. ' found', 400);
        }
    }
}