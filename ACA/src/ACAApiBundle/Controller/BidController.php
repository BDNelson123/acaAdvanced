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
     * Returns an array of errors based on user input for a Bid
     * @param Request $request
     * @return array
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


    /**
     * @return JsonResponse
     */
    public function getAction()
    {
        $response = new JsonResponse();
        $data = $this->get('rest_service')->get('bid');

        if ($data) {

            $response->setData($data);

        } else {

            $response->setStatusCode(400)
                ->setData(array(
                    'message' => 'Index request found no records'
                )
            );
        }
        return $response;
    }

    /**
     * @param $slug
     * @return Response\JsonResponse
     */
    public function showAction($slug)
    {
        $response = new JsonResponse();
        // $data = $this->get('rest_service')->get('bid', $slug);

        $bid = $this->getDoctrine()
            ->getRepository('ACAApiBundle:BidEntity')
            ->find($slug);

        if (!$bid) {
            $response->setStatusCode(400)->setData(array('message' => 'No record found'));
        }

        $response->setData($bid->getData());

        return $response;
    }

    public function postAction(Request $request)
    {
        $response = new JsonResponse();
        $data = json_decode($request->getContent(), true);
        $data['bid_date'] = new \DateTime($data['bid_date']);
        $errors = $this->bidErrors($request);

        if(empty($errors)) {

            // $this->get('rest_service')->post('bid', $data);

            $em = $this->getDoctrine()->getManager();
            $bid = new BidEntity();
            $bid->setData($data);
//            $bid->setuser_id($data['user_id']);
//            $bid->sethouse_id($data['house_id']);
//            $bid->setbid_amount($data['bid_amount']);
//            $bid->setbid_date($data['bid_date']);

            $em->persist($bid);
            $em->flush();

            $db = $this->get('db');

            $response->setStatusCode(200)->setData(
                array(
                'message' => 'Successfully posted new record',
                'id' => $db->getLastInsertId()
                )
            );

        } else {

            $response->setStatusCode(400)->setData($errors);

        }

        return $response;
    }

//    /**
//     * @param Request $request
//     * @return Response
//     */
//    public function postAction(Request $request)
//    {
//        $response = new Response;
//        $data = Bid::validatePost($request);
//        if ($data) {
//            if ($this->get('rest_service')->post('bid', $data))
//            {
//                $response->setStatusCode(200)->setContent('Posted new record to /bid');
//            } else { $response->setStatusCode(500)->setContent('Query failed');
//                // ... whoops, bad SQL query
//            }
//        } else {
//            $response->setStatusCode(400)->setContent('Invalid request; expected Json with fields "user_id", "house_id", "bid_amount"');
//            // ... the request didn't validate so $data was false
//        }
//        return $response;
//    }



    /**
     * @param $slug
     * @param Request $request
     * @return Response
     */
    public function putAction($slug, Request $request)
    {
        $response = new JsonResponse();
        $data = json_decode($request->getContent(), true);
        $errors = $this->bidErrors($request);

        if (empty($errors)) {
            if ($this->get('rest_service')->put('bid', $slug, $data))
            {
                $response->setStatusCode(200)->setData(array('message' => 'Successfully updated record ' .$slug));
            } else {
                $response->setStatusCode(500)->setData(array('message' => 'Query failed'));
            }
        } else {
            $response->setStatusCode(400)->setData($errors);
        }

        return $response;
    }

    /**
     * @param $slug
     * @return Response
     */
    public function deleteAction($slug) {
        $response = new Response();
        if ($this->get('rest_service')->delete('bid', $slug)) {
            $response->setStatusCode(200)->setData(array('message' => 'Successfully deleted record ' . $slug));
        } else {
            $response->setStatusCode(500)->setData(array('message' => 'Query failed'));
        }
        return $response;

    }
}
