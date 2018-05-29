<?php
/**
 * AccountManagerController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category AccountManagerController
 * @package  Controller
 * @author   WildCodeSchool <gaetant@wildcodeschool.fr>
 */
namespace AppBundle\Controller;

use AppBundle\Entity\AccountManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Accountmanager controller.
 *
 * @Route("accountmanager")
 *
 * @category Controller
 * @package  Controller
 * @author   WildCodeSchool <gaetant@wildcodeschool.fr>
 */
class AccountManagerController extends Controller
{
    /**
     * Lists all accountManager entities.
     *
     * @Route("/",    name="accountmanager_index")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $accountManagers = $em->getRepository('AppBundle:AccountManager')->findAll();

        return $this->render(
            'accountmanager/index.html.twig', array(
            'accountManagers' => $accountManagers,
            )
        );
    }

    /**
     * Finds and displays a accountManager entity.
     *
     * @param AccountManager $accountManager The accountManager entity
     *
     * @Route("/{id}", name="accountmanager_show")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function showAction(AccountManager $accountManager)
    {

        return $this->render(
            'accountmanager/show.html.twig', array(
            'accountManager' => $accountManager,
            )
        );
    }
}
