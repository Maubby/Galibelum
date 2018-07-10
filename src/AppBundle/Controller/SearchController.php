<?php
/**
 * SearchController File Doc Comment
 *
 * PHP version 7.2
 *
 * @category SearchController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Activity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/search", name="search_index")
     * @return           string
     */
    public function indexAction(Request $request)
    {
        if ($this->getUser()->hasRole('ROLE_STRUCTURE')
            && $this->getUser()->getOrganization()->getIsActive() === 1
            || $this->getUser()->hasRole('ROLE_COMPANY')
            && $this->getUser()->getOrganization()->getIsActive() === 1
        ) {
            $session = $request->getSession();
            return $this->render(
                'search/index.html.twig', array(
                    'name' => $session->get('name'),
                    'date' => $session->get('date'),
                    'type' => $session->get('type'),
                    'amountStart' => $session->get('amount-start'),
                    'amountEnd' => $session->get('amount-end')
                )
            );
        }
        return $this->redirectToRoute('redirect');
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
        if ($this->getUser()->hasRole('ROLE_STRUCTURE')
            && $this->getUser()->getOrganization()->getIsActive() === 1
            || $this->getUser()->hasRole('ROLE_COMPANY')
            && $this->getUser()->getOrganization()->getIsActive() === 1
        ) {
            $session = $request->getSession();

            if ($request->get('name')) {
                $session->set('name', $request->get('name'));
            } else {
                $session->set('name', "");
            }


            $request->get('type')
                ? $session->set('type', $request->get('type'))
                : $session->set('type', "0");

            $request->get('amount-start')
                ? $session->set('amount-start', $request->get('amount-start'))
                : $session->set('amount-start', 0);
            $request->get('amount-end')
                ? $session->set('amount-end', $request->get('amount-end'))
                : $session->set('amount-end', 100000);

            $request->get('date')
                ? $session->set('date', new \DateTime($request->get('date')))
                : $session->set('date', new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $activityList = $em->getRepository(Activity::class)
                ->search(
                    $session->get('name'),
                    $session->get('type'),
                    $session->get('date'),
                    $session->get('amount-start'),
                    $session->get('amount-end')
                );

            return $this->render(
                'search/index.html.twig', array(
                    'activitylist' => $activityList,
                    'date' => $session->get('date'),
                    'name' => $session->get('name'),
                    'type' => $session->get('type'),
                    'amountStart' => $session->get('amount-start'),
                    'amountEnd' => $session->get('amount-end')
                )
            );
        }
        return $this->redirectToRoute('redirect');
    }
}