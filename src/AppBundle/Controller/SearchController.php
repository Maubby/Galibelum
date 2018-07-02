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
use AppBundle\Entity\Organization;
use AppBundle\Repository\ActivityRepository;
use AppBundle\Repository\OrganizationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;


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
        $data = $session->get('data');

        return $this->render(
            'search/index.html.twig',array(
          /*  'form' => $form->createView(),*/
                'data' => $data,
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

        $session->set('data', $request->get('search'));

        $data = $session->get('data');

        $em = $this->getDoctrine()->getManager();
        $activities = $em->getRepository('AppBundle\Entity\Activity')->findAll();
        $activityRepository = $this->getDoctrine()->getRepository(Activity::class);

        $activitylist
            = $activityRepository->search($data);


        return $this->render(
            'search/index.html.twig', array(
                'activitylist' => $activitylist,
                'activities' => $activities,
                'data' => $data,
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