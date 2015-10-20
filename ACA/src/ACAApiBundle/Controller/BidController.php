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
        $userid = $data['userid'];
        $houseid = $data['houseid'];
        $bidamount = $data['bidamount'];
        $biddate = $data['biddate'];
        $errors = [];

        // Check if userid has been inputted
        if(empty($userid)) {
            $errors['userid'] = 'Please provide a userid.';
        }

        // Check to see if userid exists
        if(!($this->get('rest_service')->get('user', $userid))) {
            $errors['userid'] = 'This userid does not exist.';
        }

        // Add check to see if existing houseid
        if(empty($houseid)) {
            $errors['houseid'] = 'Please provide a houseid.';
        }

        // Check to see if houseid exists
        if(!($this->get('rest_service')->get('house', $houseid))) {
            $errors['houseid'] = 'This houseid does not exist.';
        }

        if(!empty($bidamount) && ($bidamount < 1000 || $bidamount > 99999999)) {
            $errors['bidamount'] = 'Please provide a realistic bid amount.';
        } elseif(empty($bidamount)) {
            $errors['bidamount'] = 'Please provide a bid amount.';
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
        $data['biddate'] = new \DateTime($data['biddate']);
        $errors = $this->bidErrors($request);

        if(empty($errors)) {

            // $this->get('rest_service')->post('bid', $data);

            $em = $this->getDoctrine()->getManager();
            $bid = new BidEntity();
            $bid->setData($data);
//            $bid->setUserId($data['userid']);
//            $bid->setHouseId($data['houseid']);
//            $bid->setBidAmount($data['bidamount']);
//            $bid->setBidDate($data['biddate']);

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
//            $response->setStatusCode(400)->setContent('Invalid request; expected Json with fields "userid", "houseid", "bidamount"');
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