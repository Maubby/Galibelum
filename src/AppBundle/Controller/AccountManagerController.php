<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AccountManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Accountmanager controller.
 *
 * @Route("accountmanager")
 */
class AccountManagerController extends Controller
{
    /**
     * Lists all accountManager entities.
     *
     * @Route("/", name="accountmanager_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $accountManagers = $em->getRepository('AppBundle:AccountManager')->findAll();

        return $this->render('accountmanager/index.html.twig', array(
            'accountManagers' => $accountManagers,
        ));
    }

    /**
     * Finds and displays a accountManager entity.
     *
     * @Route("/{id}", name="accountmanager_show")
     * @Method("GET")
     */
    public function showAction(AccountManager $accountManager)
    {

        return $this->render('accountmanager/show.html.twig', array(
            'accountManager' => $accountManager,
        ));
    }
}
