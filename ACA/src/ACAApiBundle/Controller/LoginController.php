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
        $authService = $this->get('auth_service');
        $data = User::validateLogin($request);
        if (gettype($data) === 'array') {
            if ($authService->tryLogin($data['username'], $this->container->get('security.password_encoder')->encodePassword(new User, $data['password']))) {
                return new Response('API key:' .$authService->createToken($data['username']), 200);
            } else {
                return new Response('Login refused; invalid credentials', 403);
            }
        } else {
            return new Response('Invalid request; ' .$data, 400);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function logoutAction(Request $request) {
        $authService = $this->get('auth_service');

        // Must actually have an auth token in order to destroy your auth token
        $error = $authService->authenticateRequest($request);
        if ($error) { return new Response('Authentication failed; ' .$error, 401); }

        $authService->destroyKey($request->headers->get('apikey'));
        return new Response('Logged out', 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function registerAction(Request $request) {

        $data = User::validatePost($request);

        if (gettype($data) === 'array') {
            // Hash that password
            $data['password'] = $this->container->get('security.password_encoder')->encodePassword(new User, $data['password']);

            if ($this->get('rest_service')->post('user', $data)) {
                return new Response('API key:' .$this->get('auth_service')->createToken($request), 200);
            } else {
                return new Response('Request failed; internal server error', 500);
            }
        } else {
            return new Response('Invalid request; ' .$data, 400);
        }
    }
}