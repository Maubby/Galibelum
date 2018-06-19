<?php
/**
 * OrganizationController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category OrganizationController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Organization;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Organization controller.
 *
 * @Route("organization")
 *
 * @category OrganizationController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class OrganizationController extends Controller
{
    /**
     * Lists all organization entities.
     *
     * @Route("/index", name="organization_index")
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
     * Lists all organization entities.
     *
     * @Route("/",    name="dashboard_index")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function dashboardAction()
    {
        $user = $this->getUser();
        $isActive = $user->getOrganization()->getIsActive();

        if ($user->hasRole('ROLE_STRUCTURE') && $isActive === 1
            || $user->hasRole('ROLE_MARQUE')  && $isActive === 1
        ) {
            $organization = $user->getOrganization();

            return $this->render(
                'dashboard/index.html.twig', array(
                    'user' => $user,
                    'organization' => $organization,
                )
            );
        } elseif ($user->hasRole('ROLE_STRUCTURE') && $isActive === 0
            || $user->hasRole('ROLE_MARQUE') && $isActive === 0
        ) {
            return $this->redirectToRoute('waiting_index');
        } else {
            return $this->redirectToRoute('inscription_index');
        }
    }

    /**
     * Creates a new organization entity.
     *
     * @param Request $request New posted info
     * @param int     $choose  organization or company
     *
     * @Route("/new/choose{choose}", name="organization_new")
     * @Method({"GET",               "POST"})
     *
     * @return Response A Response instance
     */
    public function newAction(Request $request,int $choose=null )
    {
        $organization = new Organization();
        $user = $this->getUser();
        $form = $this->createForm('AppBundle\Form\OrganizationType', $organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $organization->setUser($user);
            $organization->setNameCanonical(strtolower($organization->getName()));
            $em->persist($organization);
            $em->persist($this->getUser()->setOrganization($organization));

            if ($choose === 0) {
                $role = $this->getUser()->setRoles(array('ROLE_STRUCTURE'));
            }
            else ($choose === 1){
                $role = $this->getUser()->setRoles(array('ROLE_MARQUE'))
            };

            $em->persist($role);
            $em->flush();

            return $this->redirectToRoute(
                'dashboard_index',
                array('id' => $organization->getId(),
                )
            );
        }

        return $this->render(
            'organization/new.html.twig', array(
                'organization' => $organization,
                'form' => $form->createView(),
                'choose'=>$choose,
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
        $editForm = $this->createForm(
            'AppBundle\Form\OrganizationType',
            $organization
        );
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
     * @return \Symfony\Component\Form\FormInterface
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
