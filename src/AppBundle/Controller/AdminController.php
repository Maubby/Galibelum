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
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('admin/index.html.twig',
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

    /**
     * Deletes a manager entity.
     *
     * @param Request      $request      Delete posted info
     * @param User $manager The account manager
     *
     * @Route("/{id}",   name="admin_delete")
     * @Method("DELETE")
     *
     * @return Response A Response instance
     */
    public function deleteAction(Request $request, User $manager)
    {
        $form = $this->_createDeleteForm($manager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $manager->isEnabled(0);
            $em->persist($manager);
            $em->flush();
        }

        return $this->redirectToRoute('admin_index');
    }

    /**
     * Creates a form to delete a manager entity.
     *
     * @param User $manager The manager entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function _createDeleteForm(User $manager)
    {
        return $this
            ->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'manager_delete',
                    array('id' => $manager->getId())
                )
            )
            ->setMethod('DELETE')
            ->getForm();
    }
}