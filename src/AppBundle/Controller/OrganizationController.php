<?php
/**
 * OrganizationController File Doc Comment
 *
 * PHP version 7.2
 *
 * @category OrganizationController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Organization;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/", methods={"GET"}, name="dashboard_index")
     *
     * @return Response A Response instance
     */
    public function dashboardAction()
    {
        if ($this->getUser()->hasRole('ROLE_STRUCTURE')
            && $this->getUser()->getOrganization()->getIsActive() === 1
        ) {
            $organization = $this->getUser()->getOrganization();
            $em = $this->getDoctrine()->getManager();
            $activities = $em->getRepository('AppBundle:Activity')->findBy(
                array(
                    'organizationActivities' => $this->getUser()->getOrganization(),
                    'isActive' => true
                ),
                array(
                    'creationDate' => 'ASC'
                ),
                6
            );
            $offers = $em->getRepository('AppBundle:Offer')->findBy(
                array(
                    'activity' => $this->getUser()->getOrganization()
                        ->getOrganizationActivity()->getValues(),
                    'isActive' => true
                ),
                array(
                    'creationDate' => 'ASC'
                ),
                6
            );

            return $this->render(
                'dashboard/index.html.twig', array(
                    'organization' => $organization,
                    'activities' => $activities,
                    'offers' => $offers,
                    'manager' => $this->getUser()->getOrganization()->getManagers(),
                )
            );
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Creates a new organization entity.
     *
     * @param Request $request New posted info
     * @param int     $choose  Organization or company
     *
     * @Route("/new/choose/{choose}", methods={"GET", "POST"},
     *     name="organization_new")
     *
     * @return Response A Response instance
     */
    public function newAction(Request $request, int $choose = 0)
    {
        if ($this->getUser()->getOrganization() === null
            && $this->getUser()->hasRole('ROLE_USER')
        ) {
            $organization = new Organization();
            if ($choose === 1) {
                $form = $this
                    ->createForm(
                        'AppBundle\Form\OrganizationType', $organization
                    );
                $form->remove('status');
            } else {
                $form = $this
                    ->createForm(
                        'AppBundle\Form\OrganizationType', $organization
                    );
            }

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $organization->setUser($this->getUser());
                $organization->setNameCanonical($organization->getName());
                $this->getUser()->setOrganization($organization);
                $choose === 0 ? $this->getUser()->setRoles(array('ROLE_STRUCTURE'))
                    : $this->getUser()->setRoles(array('ROLE_COMPANY'));

                // Persisting user according to its new organization
                $em->persist($organization);
                $em->persist($this->getUser());
                $em->flush();

                return $this->redirectToRoute(
                    'dashboard_index',
                    array('id' => $organization->getId()
                    )
                );
            }

            return $this->render(
                'organization/new.html.twig', array(
                    'organization' => $organization,
                    'form' => $form->createView(),
                    'choose' => $choose
                )
            );
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Displays a form to edit an existing organization entity.
     *
     * @param Request      $request      Edit posted info
     * @param Organization $organization The organization entity
     *
     * @Route("/{id}/edit", methods={"GET", "POST"}, name="organization_edit")
     *
     * @return Response A Response instance
     */
    public function editAction(Request $request, Organization $organization)
    {
        if ($this->getUser()->getOrganization()->getId() === $organization->getId()
        ) {
            $deleteForm = $this->_createDeleteForm($organization);
            if ($this->getUser()->hasRole('ROLE_COMPANY')) {
                $editForm = $this
                    ->createForm(
                        'AppBundle\Form\OrganizationType', $organization
                    );
                $editForm->remove('status');
            } else {
                $editForm = $this
                    ->createForm(
                        'AppBundle\Form\OrganizationType', $organization
                    );
            }
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash(
                    'success',
                    "Vos modifications ont bien été prises en compte."
                );

                return $this->redirectToRoute(
                    'dashboard_index',
                    array('id' => $organization->getId())
                );
            }

            return $this->render(
                'organization/edit.html.twig', array(
                    'organization' => $organization,
                    'manager' => $this->getUser()->getOrganization()->getManagers(),
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView()
                )
            );
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Deletes an organization entity.
     *
     * @param Request      $request      Delete posted info
     * @param Organization $organization The organization entity
     *
     * @Route("/{id}", methods={"DELETE"}, name="organization_delete")
     *
     * @return Response A Response instance
     */
    public function deleteAction(Request $request, Organization $organization)
    {
        if ($this->getUser()->getOrganization()->getId() === $organization->getId()
        ) {
            $form = $this->_createDeleteForm($organization);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $organization->setIsActive(2)
                    ->getUser()->setEnabled(false);
                $em->persist($organization);
                $em->persist($this->getUser()->setEnabled(false));
                $em->flush();
            }
            $this->addFlash(
                'success',
                "Votre compte a bien été désactivé. 
            Si vous souhaitez nous rejoindre de nouveau, contactez Galibelum."
            );
            return $this->redirectToRoute('fos_user_security_logout');
        }
        return $this->redirectToRoute('redirect');
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