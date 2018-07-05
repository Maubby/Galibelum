<?php
/**
 * WaitingController File Doc Comment
 *
 * PHP version 7.2
 *
 * @category WaitingController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Waiting controller.
 *
 * @Route("waiting")
 *
 * @category WaitingController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class WaitingController extends Controller
{
    /**
     * Company & Organization wait until their application is approved
     * by the Account Manager
     *
     * @Route("/", methods={"GET"}, name="waiting_index")
     *
     * @return Response A Response instance
     */
    public function indexAction()
    {
        $user = $this->getUser();

        if ($user->hasRole('ROLE_MANAGER') || $user->hasRole('ROLE_SUPER_ADMIN')
        ) {
            return $this->redirectToRoute('manager_contract_list');

        } elseif ($user->hasRole('ROLE_STRUCTURE')
            && $user->getOrganization()->getIsActive() === 1
            || $user->hasRole('ROLE_COMPANY')
            && $user->getOrganization()->getIsActive() === 1
        ) {
            return $this->redirectToRoute('dashboard_index');

        } elseif ($user->hasRole('ROLE_STRUCTURE')
            && $user->getOrganization()->getIsActive() === 0
            || $user->hasRole('ROLE_COMPANY')
            && $user->getOrganization()->getIsActive() === 0
        ) {
            return $this->render('waiting/index.html.twig');

        } else {
            return $this->redirectToRoute('inscription_index');
        }
    }
}