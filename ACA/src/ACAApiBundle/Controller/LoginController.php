<?php

namespace ACAApiBundle\Controller;

use ACAApiBundle\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LoginController
 * @package ACAApiBundle\Controller
 *
 */

class LoginController extends Controller {

    /**
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $data = $this->get('login_service')->validateLogin($request);
        if ($this->isError($data)) {
            return new Response('Invalid request; ' .$data, 400);
        } else {
            if ($this->get('login_service')->tryLogin($data['username'], $data['password'])) {
                return new Response('API key:' .$this->get('auth_service')->createToken($data['username']), 200);
            } else {
                return new Response('Login refused; invalid credentials', 403);
            }
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function logoutAction(Request $request) {
        $authService = $this->get('auth_service');

        // Must actually have a valid auth token in order to destroy your auth token
        $auth = $authService->authenticateRequest($request);
        if ($this->isError($auth)) { return new Response('Authentication failed; ' .$auth, 401); }

        $authService->destroyKey($request->headers->get('apikey'));
        return new Response('Logged out', 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function registerAction(Request $request) {
        $data = $this->get('user_validator')->validateRegister($request);
        if ($this->isError($data)) {
            return new Response('Invalid request; ' .$data, 400);
        } else {
            if ($this->get('rest_service')->post('user', $data)) {
                return new Response('API key:' .$this->get('auth_service')->createToken($data['username']), 200);
            } else {
                return new Response('Request failed; internal server error', 500);
            }
        }
    }

    private function isError($data) { return gettype($data) === 'string'; }
}