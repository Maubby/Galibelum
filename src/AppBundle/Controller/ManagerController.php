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

use AppBundle\Entity\Contracts;
use AppBundle\Entity\Offer;
use AppBundle\Entity\Organization;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\MailerService;


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
                'organizations' => $organizations
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
        $organization->setIsActive(1);
        $organization->setManagers($this->getUser());
        $this->getDoctrine()->getManager()->persist($organization);
        $this->getDoctrine()->getManager()->flush();

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
        $organization->setIsActive(2);
        $this->getDoctrine()->getManager()->persist($organization);
        $this->getDoctrine()->getManager()->flush();

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

        $organizations = $em->getRepository('AppBundle:Organization')->findby(
            array(
                'managers' => $this->getUser(),
                'user' => $em->getRepository(
                    'AppBundle:User')->findByRole('ROLE_COMPANY'),
            )
        );

        $contracts = $em->getRepository('AppBundle:Contracts')->findBy(
            array(
                'organization' => $organizations
            )
        );

        return $this->render(
            'manager/contract.html.twig', array(
                'contracts' => $contracts
            )
        );
    }
}