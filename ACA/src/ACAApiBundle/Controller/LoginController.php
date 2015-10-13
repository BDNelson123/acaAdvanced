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
        $data = User::validateLogin($request);
        if (gettype($data) === 'array') {
            if ($this->get('login_service')
                ->tryLogin($data['username'], $this->container->get('security.password_encoder')
                                                ->encodePassword(new User, $data['password']))) {
                return new Response('API key:' .$this->get('auth_service')->createToken($data['username']), 200);
            } else {
                return new Response('Could not login; bad credentials', 403);
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
        $auth = $authService->authenticateRequest($request);
        if ($auth != true) {
            return new Response('Authentication failed; ' .$auth, 403);
        }
        $authService->destroyToken($authService->getUsernameForApikey($request->headers->get('apikey')));
        return new Response('Logged out', 200);
    }
}