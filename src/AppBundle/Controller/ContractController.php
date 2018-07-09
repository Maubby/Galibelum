<?php
/**
 * ContractController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category ContractController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Contracts;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Offer;
use AppBundle\Entity\Organization;
use AppBundle\Service\MailerService;

/**
 * Contract controller.
 *
 * @Route("contract")
 *
 * @category ContractController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class ContractController extends Controller
{
    /**
     * Lists all contracts.
     *
     * @route("/", methods={"GET"},
     *     name="contract_index")
     *
     * @return Response A Response instance
     */
    public function contractAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organization = $em->getRepository('AppBundle:Contracts')->findBy(
            array(
                'id' => $this->getUser()
            )
        );

        return $this->render(
            'contractualisation/index.html.twig', array(
                'organization' => $organization,
            )
        );
    }

    /**
     * Displays a form to edit an existing offer entity.
     *
     * @param Offer $offer The offer entity
     *
     * @Route("/{id}/partners", methods={"GET", "POST"}, name="contract_relation")
     *
     * @return Response A Response instance
     */
    public function partnersAction(Offer $offer)
    {
        if ($this->getUser()->hasRole('ROLE_COMPANY')
            && $this->getUser()->getOrganization()->getIsActive() === 1
        ) {
            $contract = new Contracts();
            $contract
                ->setStatus(1)
                ->setOffer($offer)
                ->setOrganization($this->getUser()->getOrganization());
            $this->getDoctrine()->getManager()->persist($contract);
            $this->getDoctrine()->getManager()->flush();

            return $this->render(
                'activity/show.html.twig', array(
                    'activity' => $offer->getActivity()
                )
            );
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Changes contracts' status.
     *
     * @param Contracts $contract
     * @param Int $status Status value
     *
     * @return Response A Response Instance
     * @route("/{id}/{status}", methods={"GET"},
     *     name="contract_status")
     *
     */
    public function statusAction(Contracts $contract, int $status)
    {
        if ($status >= 0 && $status <= 5) {
            $contract->setStatus($status);

            if ($contract->getStatus() === 2) {
                $contract->getOffer()->removePartnershipNumber();
            }
            if ($contract->getStatus() === 5) {
                $contract->getOffer()->addPartnershipNumber();
            }

            $this->getDoctrine()->getManager()->persist($contract);
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
     * @route("/{id}/status/{status}", methods={"GET"},
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