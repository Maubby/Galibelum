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

        $organization = $em->getRepository('AppBundle:Organization')->findBy(
            array(
                'managers' => $this->getUser(),
                'user' => $em->getRepository(
                    'AppBundle:User')->findByRole('ROLE_COMPANY'),
            )
        );

        return $this->render(
            'manager/contract.html.twig', array(
                'organizations' => $organization
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
            $offer->setStatus($status);

            if ($offer->getStatus() === 2) {
                $offer->removePartnershipNumber();
            }
            if ($offer->getStatus() === 5) {
                $offer->addPartnershipNumber();
            }

            $this->getDoctrine()->getManager()->persist($offer);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirectToRoute(
            'manager_contract_list'
        );
    }

    /**
     * Send a mail when the offers' status change.
     *
     * @param Offer         $offer      The offer entity
     * @param Int           $status     Received status
     * @param MailerService $mailerUser Mailer service
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @route("/contract/{id}/status/{status}", methods={"GET"},
     *     name="manager_contract_status_mail")
     *
     * @return                                  Response A Response Instance
     */
    public function sendAction(Offer $offer, int $status, MailerService $mailerUser)
    {
        if ($status === 2) {
            //      Mail for the structure
            $mailerUser->sendEmail(
                'William@gallibelum.fr',
                $offer->getActivity()->getOrganizationActivities()->getEmail(),
                'Validation',
                'Une marque s\'est positionnée sur votre offre'
            );
            //      Mail for the company
            $mailerUser->sendEmail(
                'William@gallibelum.fr',
                $offer->getOrganization()->getEmail(),
                'Validation',
                'Vous vous êtes positionnés sur une offre'
            );
        } elseif ($status === 3) {
            //      Mail for the structure
            $mailerUser->sendEmail(
                'William@gallibelum.fr',
                $offer->getActivity()->getOrganizationActivities()->getEmail(),
                'Paiement',
                'Une marque s\'est positionnée sur votre offre'
            );
            //      Mail for the company
            $mailerUser->sendEmail(
                'William@gallibelum.fr',
                $offer->getOrganization()->getEmail(),
                'Paiement',
                'Vous vous êtes positionnés sur une offre'
            );
        } elseif ($status === 4) {
            //      Mail for the structure
            $mailerUser->sendEmail(
                'William@gallibelum.fr',
                $offer->getActivity()->getOrganizationActivities()->getEmail(),
                'Offre expirée',
                'Une marque s\'est positionnée sur votre offre'
            );
            //      Mail for the company
            $mailerUser->sendEmail(
                'William@gallibelum.fr',
                $offer->getOrganization()->getEmail(),
                'Offre expirée',
                'Vous vous êtes positionnés sur une offre'
            );
        } elseif ($status === 5) {
            //      Mail for the structure
            $mailerUser->sendEmail(
                'William@gallibelum.fr',
                $offer->getActivity()->getOrganizationActivities()->getEmail(),
                'Offre refusée',
                'Une marque s\'est positionnée sur votre offre'
            );
            //      Mail for the company
            $mailerUser->sendEmail(
                'William@gallibelum.fr',
                $offer->getOrganization()->getEmail(),
                'Offre refusée',
                'Vous vous êtes positionnés sur une offre'
            );
        }
        return $this->redirectToRoute('manager_contract_list');
    }
}