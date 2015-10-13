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
        $auth = $this->get('auth_service')->authenticateRequest($request);
        if ($this->isError($auth)) { return new Response('Authentication failed; ' .$auth, 401); }

        $data = $this->get('rest_service')->get('user');
        if ($data) {
            return new JsonResponse($this->cleanup($data), 200);
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
        $auth = $this->get('auth_service')->authenticateRequest($request);
        if ($this->isError($auth)) { return new Response('Authentication failed; ' .$auth, 401); }

        $data = $this->get('rest_service')->get('user', $slug);
        if ($data) {
            return new JsonResponse($this->cleanup($data), 200);
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
        $auth = $this->get('auth_service')->authenticateRequest($request);
        if ($this->isError($auth)) { return new Response('Authentication failed; ' .$auth, 401); }
        if (!$this->isOwner($request, $slug)) { return new Response('Permission denied', 403); }

        $data = $this->get('user_validator')->validatePut($request);
        if ($this->isError($data)) {
            return new Response('Invalid request; ' .$data, 400);
        } else {
            if ($this->get('rest_service')->put('user', $slug, $data)) {
                return new Response('Succesfully updated record ' .$slug, 200);
            } else {
                return new Response('Request failed; internal server error', 500);
            }
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
        $auth = $this->get('auth_service')->authenticateRequest($request);
        if ($this->isError($auth)) { return new Response('Authentication failed; ' .$auth, 401); }
        if (!$this->isOwner($request, $slug)) { return new Response('Permission denied', 403); }

        if ($this->get('rest_service')->delete('user', $slug)) {
            return new Response('Successfully deleted record ' . $slug, 200);
        } else {
            return new Response('No record ' .$slug. ' found', 400);
        }
    }

    /**
     * Clean up fields that the client shouldn't see
     * @param array|object
     * @return array|object
     */
    private function cleanup($data) {
        if (gettype($data) === 'array') {
            foreach($data as $d) {
                unset($d->password);
                unset($d->roles);
                unset($d->apikey);
            }
        } elseif (gettype($data) === 'object') {
            unset($data->password);
            unset($data->roles);
            unset($data->apikey);
        }
        return $data;
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

    /**
     * @param $data
     * @return bool
     */
    private function isError($data) { return gettype($data) === 'string'; }
}