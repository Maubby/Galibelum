<?php
/**
 * ManagerController File Doc Comment
 *
 * PHP version 7.2
 *
 * @category ManagerController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Offer;
use AppBundle\Entity\Organization;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/", methods={"GET"}, name="manager_contract")
     *
     * @return Response A Response instance
     */
    public function dashboardAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findByRole('ROLE_MANAGER');
        return $this->render(
            'manager/contract.html.twig', array(
                'users' => $this->getUser(),
            )
        );
    }

    /**
     * Lists all organization entities.
     *
     * @Route("/organization", methods={"GET"}, name="manager_organization_list")
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
     * Activates an organization entity.
     *
     * @param Organization $organization The organization entity
     *
     * @Route("/activate/{id}", methods={"GET"},
     *     name="manager_organization_activate")
     *
     * @return Response A Response Instance
     */
    public function activateAction(Organization $organization)
    {
        $em = $this->getDoctrine()->getManager();
        $organization->setIsActive(1);
        $em->persist($organization);
        $organization->setManagers($this->getUser());
        $em->flush();

        return $this->redirectToRoute('manager_organization_list');
    }

    /**
     * Disable one organization.
     *
     * @param Organization $organization The organization entity
     *
     * @route("/disable/{id}", methods={"GET"}, name="manager_organization_disable")
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
     * @Route("/contract", methods={"GET"}, name="manager_contract_list")
     *
     * @return Response A Response instance
     */
    public function contractAction()
    {
        $em = $this->getDoctrine()->getManager();

        $offers = $em->getRepository(Offer::class)->findBy(array(
            'id' => $this->getUser()->getManager()->getValues()
        ));


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
     * @route("/contract/{id}/{status}", methods={"GET"},
     *     name="manager_contract_status")
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