<?php
/**
 * ManagerController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category ManagerController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Organization;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Manager controller.
 *
 * @Route("manager")
 *
 * @category ManagerController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class ManagerController extends Controller
{
    /**
     * Lists all managers.
     *
     * @Route("/",    name="manager_dashboard")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function dashboardAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        return $this->render(
            'manager/dashboard.html.twig',
            array('user' => $user)
        );
    }

    /**
     * Lists all organization entities.
     *
     * @Route("/organization", name="manager_organization_list")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function organizationListAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organizations = $em
            ->getRepository('AppBundle:Organization')
            ->findAll();

        return $this->render(
            'manager/index.html.twig', array(
                'organizations' => $organizations,
            )
        );
    }

    /* Method to activate an organization */
    /**
     * Activates a organization entity.
     *
     * @param Request      $request      Activate posted info
     * @param Organization $organization The organization entity
     *
     * @Route("/{id}/activate", name="manager_organization_activate")
     *
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function activateAction(Request $request, Organization $organization)
    {
        $em = $this->getDoctrine()->getManager();
        $organization->setIsActive(1);
        $em->persist($organization);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add(
                'success', 'L\'organisation a bien été activée.'
            );

        return $this->redirectToRoute('manager_organization_list');
    }

    /**
     * Deactivate one organization.
     *
     * @param Request      $request      Deactivate posted info
     * @param Organization $organization The organization entity
     *
     * @route("/{id}/deactivate", name="manager_organization_deactivate")
     *
     * @method("GET")
     *
     * @return Response A Response Instance
     */
    public function deactivateAction(Request $request, Organization $organization)
    {
        $em = $this->getDoctrine()->getManager();
        $organization->setIsActive(2);
        $em->persist($organization);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add(
                'success', 'L\'organisation a bien été désactivée.'
            );

        return $this->redirectToRoute('manager_organization_list');
    }
}