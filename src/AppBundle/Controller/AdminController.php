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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findByRole('ROLE_MANAGER');

        return $this->render(
            'admin/index.html.twig',
            array('users' => $users,)
        );
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
        $managers = new User();

        $form = $this->createForm('AppBundle\Form\RegistrationType', $managers);
        $form->remove('cgu');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $managers
                ->setCgu(1)
                ->setRoles(array('ROLE_MANAGER'))
                ->setEnabled(1);

            // Persisting user according to its new account Manager
            $em->persist($managers);
            $em->flush();

            return $this->redirectToRoute(
                'admin_index'
            );
        }

        return $this->render(
            'admin/new.html.twig', array(
                'managers' => $managers,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Delete a manager entity.
     *
     * @param User    $manager The account manager
     *
     * @Route("/{id}",   name="admin_delete")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function deleteAction(User $manager)
    {
            $em = $this->getDoctrine()->getManager();
            $manager->setEnabled(false);

            $em->persist($manager);
            $em->flush();

        return $this->redirectToRoute('admin_index');
    }
}