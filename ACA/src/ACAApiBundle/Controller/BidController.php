<?php

# GET, PUT, SHOW, POST, DELETE

namespace ACAApiBundle\Controller;

use ACAApiBundle\Services\DBCommon;
use ACAApiBundle\Model\Bid;
use ACAApiBundle\Entity\BidEntity;
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
     * @return JsonResponse
     * This action will get all the data for bids from the database.
     */
    public function getAction()
    {
        $response = new JsonResponse();

        $bids = $this->getDoctrine()
            ->getRepository('ACAApiBundle:BidEntity')
            ->findAll();

        if (!$bids) {
            $response->setStatusCode(400)
                ->setData(array(
                  'message' => 'Index request found no records'
                ));
            return $response;
        }

        $responseSetData = [];
        foreach($bids as $bid){
            $responseSetData[] = $bid->getData();
        };
        $response->setData($responseSetData);
        return $response;
    }


    /**
     * @param $slug
     * @return Response\JsonResponse
     * This action will find a particular bid from the database.
     */
    public function showAction($slug)
    {
        $response = new JsonResponse();

        $bid = $this->getDoctrine()
            ->getRepository('ACAApiBundle:BidEntity')
            ->find($slug);

        if (!$bid) {
            $response->setStatusCode(400)->setData(array(
              'message' => 'No record found'
            ));
            return $response;
        }

        $response->setData($bid->getData());
        return $response;
    }

    /**
     * @param Request $request
     * @return Response\JsonResponse
     * This action will add a particular bid to the database.
     */
    public function postAction(Request $request)
    {
        $response = new JsonResponse();
        $data = json_decode($request->getContent(), true);
        $errors = $this->bidErrors($request);

        if($errors) {
          $response->setStatusCode(400)->setData($errors);
          return $response;
      }

            $em = $this->getDoctrine()->getManager();
            $bid = new BidEntity();
            $bid->setData($data);
            $em->persist($bid);
            $em->flush();

            $db = $this->get('db');
            $response->setStatusCode(200)->setData(array(
                'message' => 'Successfully posted new record',
                'id' => $db->getLastInsertId()
                )
            );
        return $response;
    }


    /**
     * @param $slug
     * @param Request $request
     * @return Response
     * This action will update a particular bid already in the database.
     */
    public function putAction($slug, Request $request)
    {
      $response = new JsonResponse();
      $data = json_decode($request->getContent(), true);
      $errors = $this->bidErrors($request);

      if($errors) {
        $response->setStatusCode(400)->setData($errors);
        return $response;
    }

          $em = $this->getDoctrine()->getManager();
          $bid = $this->getDoctrine()
              ->getRepository('ACAApiBundle:BidEntity')
              ->find($slug);
          $bid->setData($data);
          $em->persist($bid);
          $em->flush();

          $db = $this->get('db');
          $response->setStatusCode(200)->setData(array(
              'message' => 'Successfully posted new record',
              'id' => $db->getLastInsertId()
              ));
      return $response;
    }

    /**
     * @param $slug
     * @return Response
     * This action will delete a particular bid already in the database.
     */
    public function deleteAction($slug) {
        $response = new JsonResponse();

        $bid = $this->getDoctrine()
            ->getRepository('ACAApiBundle:BidEntity')
            ->find($slug);

        if (!$bid) {
            $response->setStatusCode(400)->setData(array(
              'message' => 'No record found'
              ));
            return $response;
        };

        $em = $this->getDoctrine()->getManager();
        $em->remove($bid);
        $em->flush();

        $response->setStatusCode(200)->setData(array(
          'message' => 'Successfully deleted record ' . $slug
          ));
        return $response;
    }


    /**
     * @param Request $request
     * @return array
     * Returns an array of errors based on user input for a Bid.
     */
    // This will need to be moved to the model, AWAY from the controller.
    public function bidErrors(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $user_id = $data['user_id'];
        $house_id = $data['house_id'];
        $bid_amount = $data['bid_amount'];
        $bid_date = $data['bid_date'];
        $errors = [];

        // Check if user_id has been inputted
        if(empty($user_id)) {
            $errors['user_id'] = 'Please provide a user_id.';
        }

        // Check to see if user_id exists
        if(!($this->get('rest_service')->get('user', $user_id))) {
            $errors['user_id'] = 'This user_id does not exist.';
        }

        // Add check to see if existing house_id
        if(empty($house_id)) {
            $errors['house_id'] = 'Please provide a house_id.';
        }

        // Check to see if house_id exists
        if(!($this->get('rest_service')->get('house', $house_id))) {
            $errors['house_id'] = 'This house_id does not exist.';
        }

        if(!empty($bid_amount) && ($bid_amount < 1000 || $bid_amount > 99999999)) {
            $errors['bid_amount'] = 'Please provide a realistic bid amount.';
        } elseif(empty($bid_amount)) {
            $errors['bid_amount'] = 'Please provide a bid amount.';
        }

        return $errors;
    }
}
