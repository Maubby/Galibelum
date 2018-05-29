<?php
/**
 * OrganizationController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category OrganizationController
 * @package  Controller
 * @author   WildCodeSchool <gaetant@wildcodeschool.fr>
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Organization;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Organization controller.
 *
 * @Route("organization")
 *
 * @category Controller
 * @package  Controller
 * @author   WildCodeSchool <gaetant@wildcodeschool.fr>
 */
class OrganizationController extends Controller
{
    /**
     * Lists all organization entities.
     *
     * @Route("/",    name="organization_index")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organizations = $em->getRepository('AppBundle:Organization')->findAll();

        return $this->render(
            'organization/index.html.twig', array(
            'organizations' => $organizations,
            )
        );
    }

    /**
     * Creates a new organization entity.
     *
     * @param Request $request New posted info
     *
     * @Route("/new",  name="organization_new")
     * @Method({"GET", "POST"})
     *
     * @return Response A Response instance
     */
    public function newAction(Request $request)
    {
        $organization = new Organization();
        $form = $this->createForm('AppBundle\Form\OrganizationType', $organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organization);
            $em->flush();

            return $this->redirectToRoute(
                'organization_show',
                array('id' => $organization->getId())
            );
        }

        return $this->render(
            'organization/new.html.twig', array(
            'organization' => $organization,
            'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a organization entity.
     *
     * @param Organization $organization The organization entity
     *
     * @Route("/{id}", name="organization_show")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function showAction(Organization $organization)
    {
        $deleteForm = $this->_createDeleteForm($organization);

        return $this->render(
            'organization/show.html.twig', array(
            'organization' => $organization,
            'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing organization entity.
     *
     * @param Request      $request      Edit posted info
     * @param Organization $organization The organization entity
     *
     * @Route("/{id}/edit", name="organization_edit")
     * @Method({"GET",      "POST"})
     *
     * @return Response A Response instance
     */
    public function editAction(Request $request, Organization $organization)
    {
        $deleteForm = $this->_createDeleteForm($organization);
        $editForm = $this->createForm('AppBundle\Form\OrganizationType', $organization);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(
                'organization_edit',
                array('id' => $organization->getId())
            );
        }

        return $this->render(
            'organization/edit.html.twig', array(
            'organization' => $organization,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a organization entity.
     *
     * @param Request      $request      Delete posted info
     * @param Organization $organization The organization entity
     *
     * @Route("/{id}",   name="organization_delete")
     * @Method("DELETE")
     *
     * @return Response A Response instance
     */
    public function deleteAction(Request $request, Organization $organization)
    {
        $form = $this->_createDeleteForm($organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($organization);
            $em->flush();
        }

        return $this->redirectToRoute('organization_index');
    }

    /**
     * Creates a form to delete a organization entity.
     *
     * @param Organization $organization The organization entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function _createDeleteForm(Organization $organization)
    {
        return $this
            ->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'organization_delete',
                    array('id' => $organization->getId())
                )
            )
            ->setMethod('DELETE')
            ->getForm();
    }
}
