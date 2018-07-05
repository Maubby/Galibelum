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
use Symfony\Component\Routing\Annotation\Route;

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
     * Welcomes the admin manager.
     *
     * @Route("/", methods={"GET"}, name="admin_index")
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
     * Creates a new account manager.
     *
     * @param Request $request New posted info
     *
     * @Route("/new", methods={"GET", "POST"}, name="admin_manager_new")
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
            $manager
                ->setCgu(1)
                ->setRoles(array('ROLE_MANAGER'))
                ->setEnabled(1);
            // Persisting user according to its new account Manager
            $em->persist($manager);
            $em->flush();
            return $this->redirectToRoute(
                'admin_manager_list'
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
     * Displays a form to edit an existing manager entity.
     *
     * @param Request $request Edit posted info
     * @param User    $manager The User manager
     *
     * @Route("/{id}/edit", methods={"GET", "POST"}, name="admin_manager_edit")
     *
     * @return Response A Response instance
     */
    public function editAction(Request $request,User $manager)
    {
        $editForm = $this->createForm('AppBundle\Form\RegistrationType', $manager);
        $editForm->remove('cgu');
        $editForm->remove('phoneNumber');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this
                ->addFlash(
                    'success',
                    "Vos modifications ont bien été prises en compte."
                );

            return $this->redirectToRoute(
                'admin_manager_list',
                array('id' => $manager->getId(),)
            );
        }

        return $this->render(
            'admin/edit.html.twig', array(
                'manager' => $manager,
                'edit_form' => $editForm->createView(),
            )
        );
    }

    /**
     * Lists all account managers.
     *
     * @Route("/manager", methods={"GET"}, name="admin_manager_list")
     *
     * @return Response A Response instance
     */
    public function managerAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findByRole('ROLE_MANAGER');
        return $this->render(
            'admin/manager.html.twig',
            array('users' => $users,)
        );
    }

    /**
     * Deletes a manager entity.
     *
     * @param User $manager The account manager
     *
     * @Route("/{id}", methods={"GET"}, name="admin_delete")
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