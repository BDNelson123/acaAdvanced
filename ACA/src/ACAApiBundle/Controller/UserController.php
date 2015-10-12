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
            $response->setData(User::cleanupForDisplay($data));
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
            $response->setData(User::cleanupForDisplay($data));
        } else {
            $response = new Response;
            $response->setStatusCode(500)->setContent('No record ' .$slug. ' found');
        }
        return $response;
    }

    /**
     * In practice this will be used to register new users
     * @param Request $request
     * @return Response
     */
    public function postAction(Request $request)
    {
        $response = new Response;
        $data = User::validatePost($request);
        if (gettype($data) === 'array') {
            $data['password'] = $this->container->get('security.password_encoder')->encodePassword(new User, $data['password']);

            $this->get('rest_service')->post('user', $data) ? $response->setStatusCode(200)->setContent('Posted new record to /user') :
                                                              $response->setStatusCode(500)->setContent('Request failed; internal server error');
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
    public function putAction($slug, Request $request)
    {
        $response = new Response();
        $data = User::validatePut($request);

        if (gettype($data) === 'array') {
            if (!empty($data['password'])) {
                $data['password'] = $this->container->get('security.password_encoder')->encodePassword(new User, $data['password']);
            }

            $this->get('rest_service')->put('user', $slug, $data) ? $response->setStatusCode(200)->setContent('Succesfully updated record ' .$slug) :
                                                                    $response->setStatusCode(500)->setContent('Request failed; internal server error');
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

    /**
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $response = new Response();
        $data = User::validateLogin($request);
        if (gettype($data) === 'array') {
            $encryptedPassword = $this->container->get('security.password_encoder')->encodePassword(new User, $data['password']);
            if ($this->get('login_service')->tryLogin($data['username'], $encryptedPassword)) {
                $apikey = mcrypt_encrypt(MCRYPT_BLOWFISH, 'lamesauce', time() . '&' . $data['username'], 'ecb');
                $db = $this->get('db');
                $db->setQuery('UPDATE user SET apikey="' .$apikey. '" WHERE username="' .$data['username'] .'";');
                $db->query();
                $response->setStatusCode(200)->headers->set('apikey', $apikey);
            } else {
                $response->setStatusCode(400)->setContent('Login rejected fool');
            }
        } else {
            $response->setStatusCode(400)->setContent('Invalid request; ' .$data);
        }
        return $response;
    }

    /**
     * @return Response
     */
    public function logoutAction() {

        // Destroy my auth token, please

        $response = new Response();
        $response->setStatusCode(200)->setContent('Logged out, thanks');
        return $response;
    }
}