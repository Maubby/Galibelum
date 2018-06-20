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

use User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @Route("/",    name="waiting_index")
     * @Method("GET")
     * @return        Response A Response instance
     */
    public function indexAction()
    {
        $user = $this->getUser();

        if ($user->hasRole('ROLE_STRUCTURE')
            && $user->getOrganization()->getIsActive() === 1
            || $user->hasRole('ROLE_MARQUE')
            && $user->getOrganization()->getIsActive() === 1
        ) {
            return $this->redirectToRoute('dashboard_index');
        } else {
            return $this->render('waiting/index.html.twig');
        };
    }
}