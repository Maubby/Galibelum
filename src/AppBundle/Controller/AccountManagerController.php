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
use Symfony\Component\HttpFoundation\Request;
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
     * Creates a new AccountManager entity.
     *
     * @param Request $request Delete posted info
     *
     * @Route("/new",  name="accountmanager_new")
     * @Method({"GET", "POST"})
     *
     * @return Response A Response instance
     */
    public function newAction(Request $request)
    {
        $activity = new AccountManager();
        $form = $this->createForm('AppBundle\Form\AccountManagerType', $accountManager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accountManager);
            $em->flush();

            return $this->redirectToRoute(
                'accountmanager_show',
                array('id' => $accountManager->getId())
            );
        }

        return $this->render(
            'accountmanager/new.html.twig', array(
                'accountManager' => $accountManager,
                'form' => $form->createView(),
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

    /**
     * Displays a form to edit an existing accountManager entity.
     *
     * @param Request  $request  Delete posted info
     * @param AccountManager $accountManager The accountManager entity
     *
     * @Route("/{id}/edit", name="accountmanager_edit")
     * @Method({"GET",      "POST"})
     *
     * @return Response A Response instance
     */
    public function editAction(Request $request, AccountManager $accountManager)
    {
        $deleteForm = $this->_createDeleteForm($accountManager);
        $editForm = $this->createForm('AppBundle\Form\AccountType', $accountManager);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(
                'accountmanager_edit',
                array('id' => $accountManager->getId())
            );
        }

        return $this->render(
            'accountmanager/edit.html.twig', array(
                'accountManager' => $accountManager,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a accountManager entity.
     *
     * @param Request  $request  Delete posted info
     * @param AccountManager $accountManager The accountManager entity
     *
     * @Route("/{id}",   name="accountmanager_delete")
     * @Method("DELETE")
     *
     * @return Response A Response instance
     */
    public function deleteAction(Request $request, AccountManager $accountManager)
    {
        $form = $this->_createDeleteForm($accountManager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($accountManager);
            $em->flush();
        }

        return $this->redirectToRoute('accountmanager_index');
    }

    /**
     * Creates a form to delete a activity entity.
     *
     * @param AccountManager $accountManager The accountManager entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function _createDeleteForm(AccountManager $accountManager)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'accountmanager_delete',
                    array('id' => $accountManager->getId())
                )
            )
            ->setMethod('DELETE')
            ->getForm();
    }
}
