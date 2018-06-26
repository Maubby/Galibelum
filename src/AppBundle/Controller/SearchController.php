<?php
/**
 * Created by PhpStorm.
 * User: thibault1serre
 * Date: 14/06/18
 * Time: 21:29
 */

namespace AppBundle\Controller;

use AppBundle\Dto\OrganizationDto;
use AppBundle\Entity\Activity;
use AppBundle\Entity\Offer;
use AppBundle\Entity\Organization;
use AppBundle\Repository\OrganizationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
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
     * @return string
     *
     */
    public function indexAction()
    {
        return $this->render(
            'search/index.html.twig');
    }

    /**
     * @Route("/result", name="result")
     * @return string
     */
    public function searchAction()
    {

        $result = [];

        $data = $_POST['search'];

        if (strlen($data) < 3) {
            $result['success'] = false;
            $result['error'] = "Minimum 3 caractere requis";
        }


        $org = $this->getDoctrine()->getRepository(Organization::class)->search($data);
        $act = $this->getDoctrine()->getRepository(Activity::class)->search($data);
        $off = $this->getDoctrine()->getRepository(Offer::class)->search($data);


        //organization
        if (isset($org)) {
            $organisation = [];
            for ($i=0; $i<count($org); $i++) {
                $organisation['organization']['name'] = $org[$i]->getName();
                $organisation['organization']['description'] = $org[$i]->getDescription();
            }
        }

        //activity
        if (isset($act)) {
            $activity = [];
            for ($i = 0; $i < count($act); $i++) {
                $activity['activity']['name'] = $act[$i]->getName();
                $activity['activity']['description'] = $act[$i]->getDescription();
            }
        }

        //offer
        if (isset($off)) {
            $offer = [];
            for ($i=0; $i<count($off); $i++) {
                $offer['offer']['amount'] = $off[$i]->getAmount();
                $offer['offer']['date'] = $off[$i]->getDate();
            }
        }

        return new Response(json_encode([$organisation, $activity, $offer]));


    }
}