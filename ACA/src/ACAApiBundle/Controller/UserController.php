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
        // Need valid auth to get User index
        $error = $this->get('auth_service')->authenticateRequest($request);
        if ($error) { return new Response('Authentication failed; ' .$error, 401); }

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
        // Need auth to look at User records
        $error = $this->get('auth_service')->authenticateRequest($request);
        if ($error) { return new Response('Authentication failed; ' .$error, 401); }

        $data = $this->get('rest_service')->get('user', $slug);
        if ($data) {
            return new JsonResponse(User::cleanupForDisplay($data), 200);
        } else {
            return new Response('No record ' .$slug. ' found', 200);
        }
    }

    /**
     * @param $slug
     * @param Request $request
     * @return Response
     */
    public function putAction($slug, Request $request)
    {
        // Need auth and must be owner to modify User record
        $error = $this->get('auth_service')->authenticateRequest($request);
        if ($error) { return new Response('Authentication failed; ' .$error, 401); }
        if (!$this->isOwner($request, $slug)) { return new Response('Permission denied', 403); }

        $data = User::validatePut($request);
        if (gettype($data) === 'array') {
            // If we got a password, hash it before updating record
            if (!empty($data['password'])) {
                $data['password'] = $this->container->get('security.password_encoder')->encodePassword(new User, $data['password']);
            }
            // Put any valid data we got in that request to the record
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
        // Need auth and must be owner to delete User record
        $error = $this->get('auth_service')->authenticateRequest($request);
        if ($error) { return new Response('Authentication failed; ' .$error, 401); }
        if (!$this->isOwner($request, $slug)) { return new Response('Permission denied', 403); }

        if ($this->get('rest_service')->delete('user', $slug)) {
            return new Response('Successfully deleted record ' . $slug, 200);
        } else {
            return new Response('No record ' .$slug. ' found', 400);
        }
    }

    /**
     * Returns true if the id given in the second parameter corresponds to the
     * User owning the auth token (viz. that was passed in the Request header).
     *
     * @param Request $request
     * @param $id
     * @return bool
     */
    private function isOwner(Request $request, $id) {
        return $this->get('auth_service')->getUserIdForApiKey($request->headers->get('apikey')) === $id;
    }
}