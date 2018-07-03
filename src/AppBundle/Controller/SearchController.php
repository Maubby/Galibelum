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
use AppBundle\Repository\OfferRepository;
use AppBundle\Repository\OrganizationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Validator\Constraints\Date;


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

        $session->set('name', $request->get('name'));
        $session->set('type', $request->get('type'));
        $session->set('date', $request->get('date'));
        //$session->set('amount_min', $amount_min);
        //$session->set('amount_max', $amount_max);

        $name = $request->get('name');
        $type = $request->get('type');
        $oldDate = $request->get('date');
        $amount_min = $request->get('amount_min');
        $amount_max = $request->get('amount_max');

        if ($oldDate === ''){
            $date ='';
        }
        else {
            $date = date('d-m-Y', strtotime($oldDate));
        }


        $em = $this->getDoctrine()->getManager();
        $activities = $em->getRepository('AppBundle\Entity\Activity')->findAll();

           // var_dump($type);
            var_dump($name);
        //var_dump($date);


        $activityRepository = $this->getDoctrine()->getRepository(Activity::class);
        //$offerRepository = $this->getDoctrine()->getRepository(Offer::class);

        $activitylist = $activityRepository->search($name,$type,$date);

        //var_dump($activitylist);



        return $this->render(
            'search/index.html.twig', array(
                'activitylist' => $activitylist,
                'activities' => $activities,
                'date' => $date,
                'name' => $name,
                'type' => $type,
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