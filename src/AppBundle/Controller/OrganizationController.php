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
use AppBundle\Entity\User;
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
        $user = $this->getUser();
        if ($user->hasRole('ROLE_MANAGER') || $user->hasRole('ROLE_SUPER_ADMIN')
        ) {
            return $this->redirectToRoute('manager_contract_list');

        } elseif ($user->hasRole('ROLE_STRUCTURE')
            && $user->getOrganization()->getIsActive() === 1)
        {
            $organization = $user->getOrganization();
            
            $em = $this->getDoctrine()->getManager();
            $offers = $em
                ->getRepository('AppBundle:Offer')
                ->findBy(
                    array(
                        'id' => $this->getUser()->getOrganization()->getOrganizationActivity()->getValues()
                    )
                );

            return $this->render(
                'dashboard/index.html.twig', array(
                    'user' => $user,
                    'organization' => $organization,
                    'offers' => $offers,
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

        $user = $this->getUser();
        if ($user->hasRole('ROLE_MANAGER') || $user->hasRole('ROLE_SUPER_ADMIN')
        ) {
            return $this->redirectToRoute('manager_contract_list');

        } elseif ($user->getOrganization() === null ) {
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
                $organization->setUser($user);
                $organization->setNameCanonical(
                    strtolower(
                        str_replace(
                            ' ', '_', $organization->getName()
                        )
                    )
                );
                $user->setOrganization($organization);
                $choose === 0 ? $user->setRoles(array('ROLE_STRUCTURE'))
                    : $user->setRoles(array('ROLE_COMPANY'));

                // Persisting user according to its new organization
                $em->persist($organization);
                $em->persist($user);
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
                    'choose' => $choose,
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
        $user = $this->getUser();
        if ($user->hasRole('ROLE_MANAGER') || $user->hasRole('ROLE_SUPER_ADMIN')
        ) {
            return $this->redirectToRoute('manager_contract_list');

        } elseif ($user->getOrganization()->getId() === $organization->getId()) {
            $deleteForm = $this->_createDeleteForm($organization);
            if ($user->hasRole('ROLE_COMPANY')) {
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

                $this
                    ->addFlash(
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
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
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

        $user = $this->getUser();
        if ($user->hasRole('ROLE_MANAGER') || $user->hasRole('ROLE_SUPER_ADMIN')
        ) {
            return $this->redirectToRoute('manager_contract_list');

        } elseif ($user->getOrganization()->getId() === $organization->getId()) {
            $form = $this->_createDeleteForm($organization);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $organization->setIsActive(2);
                $user->setEnabled(false);
                $em->persist($organization);
                $em->persist($user);
                $em->flush();
            }
            $this
                ->addFlash(
                    'success',
                    "Votre compte a bien été désactivé. 
            Si vous souhaitez nous rejoindre à nouveau, contactez Galibelum."
                );

            return $this->redirectToRoute('redirect');
        }
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