<?php
/**
 * SearchController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category SearchController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Activity;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Search controller.
 *
 * @category SearchController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class SearchController extends Controller
{
    /**
     * Displaying search form
     *
     * @param Request $request Search form
     *
     * @Route("/search")
     * @return           string
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $name = $session->get('name');
        $date = $session->get('date');
        $type = $session->get('type');

        return $this->render(
            'search/index.html.twig', array(
            'name' => $name,
            'date' => $date,
            'type' => $type,
            )
        );
    }

    /**
     * Selecting activities according to some inputs
     *
     * @param Request $request Search form
     *
     * @Route("/result", name="search_action")
     * @return           Response A Response instance
     */
    public function searchAction(Request $request)
    {
        $session = $request->getSession();

        if ($request->get('name')) {
            $session->set('name', $request->get('name'));
        }

        if ($request->get('type')) {
            $session->set('type', $request->get('type'));
        } else {
            $session->set('type', "0");
        }

        if ($request->get('date')) {
            $session->set('date', new \DateTime($request->get('date')));
        } else {
            $session->set('date', new \DateTime('now'));
        }

        // Faire amount ici et factoriser les if par la suite

        $em = $this->getDoctrine()->getManager();
        $activityList = $em->getRepository(Activity::class)
            ->search(
                $session->get('name'),
                $session->get('type'), $session->get('date')
            );

        return $this->render(
            'search/index.html.twig', array(
                'activitylist' => $activityList,
                'date' => $session->get('date'),
                'name' => $session->get('name'),
                'type' => $session->get('type'),
            )
        );
    }
}