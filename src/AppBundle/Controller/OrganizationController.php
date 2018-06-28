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
use AppBundle\Entity\User;
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

        $organizations = $em
            ->getRepository('AppBundle:Organization')
            ->findByisActive(1);

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

        if ($user->hasRole('ROLE_STRUCTURE')
            && $user->getOrganization()->getIsActive() === 1
            || $user->hasRole('ROLE_COMPANY')
            && $user->getOrganization()->getIsActive() === 1
        ) {
            $organization = $user->getOrganization();

            return $this->render(
                'dashboard/index.html.twig', array(
                    'user' => $user,
                    'organization' => $organization,
                )
            );
        } elseif ($user->hasRole('ROLE_STRUCTURE')
            && $user->getOrganization()->getIsActive() === 0
            || $user->hasRole('ROLE_COMPANY')
            && $user->getOrganization()->getIsActive() === 0
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
     * @param int     $choose  Organization or company
     *
     * @Route("/new/choose/{choose}", name="organization_new")
     * @Method({"GET",                "POST"})
     *
     * @return Response A Response instance
     */
    public function newAction(Request $request, int $choose = 0)
    {
        $organization = new Organization();
        $user = $this->getUser();
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
            $organization->setNameCanonical(strtolower($organization->getName()));
            $user->setOrganization($organization);
            $choose === 0 ?$user->setRoles(array('ROLE_STRUCTURE'))
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

        if ($organization->getIsActive() === 1) {
            return $this->render(
                'organization/show.html.twig', array(
                    'organization' => $organization,
                    'delete_form' => $deleteForm->createView(),
                )
            );
        } else {
            return $this->redirectToRoute('homepage');
        }
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
        $user = $this->getUser();
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

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Vos modifications ont bien été prises en compte.');

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

    /**
     * Deletes a organization entity.
     *
     * @param Request      $request      Delete posted info
     * @param Organization $organization The organization entity
     * @param User         $user         The user entity
     *
     * @Route("/{id}",   name="organization_delete")
     * @Method("DELETE")
     *
     * @return Response A Response instance
     */
    public function deleteAction(
        Request $request, Organization $organization, User $user
    ) {
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

        $request->getSession()
            ->getFlashBag()
            ->add(
                'success', 'Votre compte a bien été désactivé. 
            Si vous souhaitez nous rejoindre à nouveau, contactez Gallibelum.'
            );

        return $this->redirectToRoute('fos_user_security_login');
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
