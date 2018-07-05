<?php
/**
 * Created by PhpStorm.
 * User: thibault1serre
 * Date: 14/06/18
 * Time: 21:29
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Activity;
use AppBundle\Entity\Offer;
use AppBundle\Repository\OfferRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Search controller.
 *
 *
 * @category SearchController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class SearchController extends Controller
{
    /**
     * @Route("/search")
     * @param Request $request
     * @return string
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $name = $session->get('name');
        $date = $session->get('date');
        $type = $session->get('type');

        if ($date ===''){
            $date ='00-00-0000';
        }
        else {
            $date = new \DateTime($date);
        }

        return $this->render(
            'search/index.html.twig',array(
            'name' => $name,
            'date' => $date,
            'type' => $type,
        ));
    }

    /**
     * @Route("/result", name="search_action")
     * @param Request $request
     * @return string
     */
    public function searchAction(Request $request)
    {
        $session = $request->getSession();

        // Faire amount
        if ($request->get('name'))
            $session->set('name', $request->get('name'));
        if ($request->get('type'))
            $session->set('type', $request->get('type'));

        if ($request->get('date'))
            $session->set('date', new \DateTime($request->get('date')));
        else
            $session->set('date', new \DateTime('now'));

        $em = $this->getDoctrine()->getManager();
        $activitylist = $em->getRepository(Activity::class)
            ->search($session->get('name'),
                $session->get('type'), $session->get('date'));

        return $this->render(
            'search/index.html.twig', array(
                'activitylist' => $activitylist,
                'date' => $session->get('date'),
                'name' => $session->get('name'),
                'type' => $session->get('type'),
            )
        );

        /*$result = [];

        $data = $_POST['search'];

        if (strlen($data) < 3) {
            $result['success'] = false;
            $result['error'] = "Minimum 3 caracteres requis";
        }

        //$org = $this->getDoctrine()->getRepository(Organization::class)->search($data);
        $act = $this->getDoctrine()->getRepository(Activity::class)->search($data);
        //$off = $this->getDoctrine()->getRepository(Offer::class)->search($data);

        //organization
        /*if (isset($org)) {
            $organisation = [];
            for ($i=0; $i<count($org); $i++) {
                $organisation['organization']['name'] []= $org[$i]->getName();
                $organisation['organization']['description'] [] = $org[$i]->getDescription();
            }
        }

        //organization
        if (isset($act)) {
            $activity = [];
            for ($i=0; $i<count($act); $i++) {
                $activity['activity']['name'] []= $act[$i]->getName();
                $activity['activity']['description'] [] = $act[$i]->getDescription();
            }
        }*/


        //activity
        /*if (isset($act)) {
             $activity = [];
             $organization = [];
             for ($i = 0; $i < count($act); $i++) {
                 $organization ['organization']['name'] [] = $act[$i]->getorganizationActivities()->getName();
                 $activity ['activity']['name'] [] = $act[$i]->getName();
                 $activity ['activity']['description'] [] = $act[$i]->getDescription();
                 $activity ['activity']['id'] [] = $act[$i]->getId();
                 $activity ['activity']['type'] [] = $act[$i]->getType();
                 //$offer['offer']['amount'] [] = $act[$i]->getActivities()->getAmount();
                 /*foreach ($act[$i]->getActivity()->getAmount() as $amount){
                     $offer['offer']['amount'] [] = $amount;
                 }*/
        //}
        //}

        //offer
        /*if (isset($off)) {
            $offer = [];
            for ($i=0; $i<count($off); $i++) {
                $offer['offer']['amount'] [] = $off[$i] ->getAmount();
                $offer['offer']['date'] [] = $off[$i]->getDate();
            }
        }*/


        //return new Response(json_encode([$organization,$activity]));
        //return new Response(json_encode([$organisation,$activity]));


        //}
    }
}