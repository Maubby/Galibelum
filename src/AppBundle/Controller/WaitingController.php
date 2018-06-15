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
        return $this->render('waiting/index.html.twig');
    }
}