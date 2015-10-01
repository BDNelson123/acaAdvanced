<?php

# GET, PUT, SHOW, POST, DELETE

namespace ACAApiBundle\Controller;

use ACAApiBundle\DBCommon;
use ACAApiBundle\Model\Bid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BidController
 * @package ACAApiBundle\Controller
 *
 */
class BidController extends Controller
{
    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function getAction()
    {

        /**
         * @var $db DBCommon
         */
        $db = $this->get('db');
        $db->setQuery('SELECT userid, houseid, bidamount, biddate FROM bid;');
        $db->query();
        $response = new JsonResponse();
        $response->setData($db->loadObjectList());
        return $response;
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws \Exception
     */
    public function showAction($slug)
    {
        /**
         * @var $db DBCommon
         */
        $db = $this->get('db');
        $db->setQuery('SELECT userid, houseid, bidamount, biddate FROM user WHERE id = ' . $slug . ';');
        $db->query();
        $response = new JsonResponse();
        $response->setData($db->loadObjectList());
        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function postAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $userid = $data['userid'];
        $houseid = $data['houseid'];
        $bidamount = $data['bidamount'];
        $biddate = $data['biddate'];
        $db = $this->get('db');
        $db->setQuery('INSERT INTO bid(userid, houseid, bidamount, biddate) VALUES("'.$userid.'", "'.$houseid.'", "'.$bidamount.'", "'.$biddate.'");');
        $db->query();
        $response = new JsonResponse();
        $response->setData(array(
            'Inserted record with ID' => $db->getLastInsertId()
        ));
        return $response;
    }

    /**
     * @param $slug
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function putAction($slug, Request $request) {

        $data = json_decode($request->getContent(), true);
        $userid = $data['userid'];
        $houseid = $data['houseid'];
        $bidamount = $data['bidamount'];
        $biddate = $data['biddate'];
        $db = $this->get('db');
        $db->setQuery('UPDATE bid SET userid="'.$userid.'", houseid="'.$houseid.'", bidamount="'.$bidamount.'", biddate="'.$biddate.'" WHERE id='.$slug.';');
        $db->query();
        $response = new Response();
        $response->setStatusCode(200);
        return $response;
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteAction($slug) {
        $db = $this->get('db');
        $db->setQuery('DELETE FROM bid WHERE id='.$slug.';');
        $db->query();
        $response = new Response();
        $response->setStatusCode(200);
        return $response;
    }
}