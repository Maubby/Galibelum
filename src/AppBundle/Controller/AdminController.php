<?php
/**
 * AdminController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category AdminController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin controller.
 *
 * @Route("admin")
 *
 * @category AdminController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class AdminController extends Controller
{
    /**
     * Lists all offer entities.
     *
     * @Route("/",    name="admin_index")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function indexAction()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     *  Creates a new account manager.
     *
     * @param Request $request New posted info
     *
     * @Route("/new",  name="admin/new.html.twig")
     * @Method({"GET", "POST"})
     *
     * @return Response A Response instance
     */
    public function newAction(Request $request)
    {
        $manager = new User();

        $form = $this->createForm('AppBundle\Form\RegistrationType', $manager);
        $form->remove('cgu');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $manager->setCgu(1);
            $manager->setRoles(array('ROLE_MANAGER'));

            // Persisting user according to its new account Manager
            $em->persist($manager);
            $em->flush();

            return $this->redirectToRoute(
                'admin_index'
            );
        }

        return $this->render(
            'admin/new.html.twig', array(
                'manager' => $manager,
                'form' => $form->createView(),
            )
        );
    }
}