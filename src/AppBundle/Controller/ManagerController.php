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

use AppBundle\Entity\Offer;
use AppBundle\Entity\Organization;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * Landing page for account managers.
     *
     * @Route("/",    name="manager_contract")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function dashboardAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findByRole('ROLE_MANAGER');
        return $this->render(
            'manager/contract.html.twig',
            array('users' => $users,)
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

    /**
     * Activates a organization entity.
     *
     * @param Organization $organization The organization entity
     *
     * @Route("/activate/{id}", name="manager_organization_activate")
     * @Method("GET")
     *
     * @return Response A Response Instance
     */
    public function activateAction(Organization $organization)
    {
        $em = $this->getDoctrine()->getManager();
        $organization->setIsActive(1);
        $em->persist($organization);
        $em->flush();

        return $this->redirectToRoute('manager_organization_list');
    }

    /**
     * Disable one organization.
     *
     * @param Organization $organization The organization entity
     *
     * @route("/disable/{id}", name="manager_organization_disable")
     * @method("GET")
     *
     * @return Response A Response Instance
     */
    public function disableAction(Organization $organization)
    {
        $em = $this->getDoctrine()->getManager();
        $organization->setIsActive(2);
        $em->persist($organization);
        $em->flush();

        return $this->redirectToRoute('manager_organization_list');
    }

    /**
     * Lists all contracts.
     *
     * @Route("/contract", name="manager_contract_list")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function contractAction()
    {
        $em = $this->getDoctrine()->getManager();

        $offers = $em
            ->getRepository('AppBundle:Offer')
            ->findAll();

        return $this->render(
            'manager/contract.html.twig', array(
                'offers' => $offers,
            )
        );
    }

    /**
     * Changes offers' status.
     *
     * @param Offer $offer  The offer entity
     * @param Int   $status Status value
     *
     * @route("/contract/{id}/{status}", name="manager_contract_status")
     * @Method("GET")
     *
     * @return Response A Response Instance
     */
    public function statusAction(Offer $offer, int $status)
    {
        if ($status >= 0 && $status <= 5) {
            $em = $this->getDoctrine()->getManager();
            $offer->setStatus($status);
            $em->persist($offer);
            $em->flush();
        }

        return $this->redirectToRoute(
            'manager_contract_list'
        );
    }
}