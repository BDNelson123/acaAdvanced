<?php

namespace ACAApiBundle\Controller;

use ACAApiBundle\Entity\UserEntity;
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
     * Get all data for all users in the user table.
     * @return Response|JsonResponse
     */
    public function getAction()
    {
        $response = new JsonResponse();
        $users = $this->getDoctrine()
            ->getRepository('ACAApiBundle:UserEntity')
            ->findAll();

        if(!$users) {
            $response->setStatusCode(400)
                ->setData(array(
                    'message' => 'Index request found no records'
                )
            );
            return $response;
        }

        $responseSetData = [];
        foreach($users as $user) {
            $responseSetData[] = $user->getData();
        }

        $response->setData($responseSetData);
        return $response;
    }

    /**
     * Find and show a particular user in the user table, based on id (slug).
     * @param $slug
     * @return Response|JsonResponse
     */
    public function showAction($slug)
    {
        $response = new JsonResponse();
        $user = $this->getDoctrine()
            ->getRepository('ACAApiBundle:UserEntity')
            ->find($slug);

        if(!$user) {
            $response->setStatusCode(400)->setData(array(
                'message' => 'No record found for id ' . $slug
            ));
            return $response;
        }

        $response->setData($user->getData());
        return $response;
    }

    /**
     * Add a user to the user table.
     * @param Request $request
     * @return Response\JsonResponse
     */
    public function postAction(Request $request)
    {
        $response = new JsonResponse();
        $data = json_decode($request->getContent(), true);
        $errors = $this->userErrors($request);

        if($errors) {
            $response->setStatusCode(400)->setData($errors);
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $user = new UserEntity();
        $user->setData($data);
        $em->persist($user);
        $em->flush();

        $response->setStatusCode(200)->setData(array(
            'message' => 'Successfully posted new user',
            'id' => $user->getId()
            )
        );

        return $response;

//        $data = User::validatePost($request);
//        if (gettype($data) === 'array') {
//              if ($this->get('rest_service')->post('user', $data))
//              {
//                  $response->setStatusCode(200)->setContent('Posted new record to /user');
//              } else {
//                  $response->setStatusCode(500)->setContent('Request failed; internal server error');
//              }
//        } else {
//            $response->setStatusCode(400)->setContent('Invalid request; ' .$data);
//        }
//        return $response;
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

    /**
     * @param Request $request
     * @return array
     * Returns an array of errors (or an empty array) based on user input for a User.
     */
    public function userErrors(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $role = $data['role'];
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $errors = [];

        // This needs further validation!
        if(empty($email)) {
            $errors['email'] = 'Please provide an email address.';
        } elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please provide a valid email address.';
        }

        if(empty($role)) {
            $errors['role'] = 'Please state whether you are a buyer or seller.';
        }

        if(empty($first_name)) {
            $errors['first_name'] = 'Please provide your first name.';
        }

        if(empty($last_name)) {
            $errors['last_name'] = 'Please provide your last name.';
        }
        return $errors;
    }
}
