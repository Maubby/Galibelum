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

        if ($this->getUser()->hasRole('ROLE_COMPANY')) {
            $contracts = $em->getRepository('AppBundle:Contracts')->findBy(
                array(
                    'organization' => $this->getUser()
                )
            );
        } else {
            $activities = $em->getRepository('AppBundle:Activity')->findby(
                array(
                    'organizationActivities' => $this->getUser()->getOrganization(),
                )
            );

            $offers = $em->getRepository('AppBundle:Offer')->findby(
                array(
                    'activity' => $activities,
                )
            );
            $contracts = $em->getRepository('AppBundle:Contracts')->findBy(
                array(
                    'offer' => $offers,
                )
            );
        }

        return $this->render(
            'contractualisation/index.html.twig', array(
                'contracts' => $contracts,
            )
        );
    }

    /**
     * Set contract when company click to relation button.
     *
     * @param Offer $offer The offer entity
     * @param MailerService $mailerUser The mailer service
     *
     * @Route("/{id}/partners", methods={"GET", "POST"}, name="contract_relation")
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return Response A Response instance
     */
    public function partnersAction(Offer $offer, MailerService $mailerUser)
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

            $mailerUser->sendEmail(
                'noreply@galibelum.fr',
                $contract->getOffer()->getActivity()
                    ->getOrganizationActivities()->getUser()->getEmail(),
                'Validation',
                'Une marque s\'est positionnée sur votre offre'
            );

            $mailerUser->sendEmail(
                'noreply@galibelum.fr',
                $contract->getOrganization()->getUser()->getEmail(),
                'Validation',
                'Vous vous êtes positionnés sur une offre'
            );

            $mailerUser->sendEmail(
                'noreply@galibelum.fr',
                $contract->getOrganization()->getManagers()->getEmail(),
                'Validation',
                'Vous vous êtes positionnés sur une offre'
            );

            $this->addFlash(
                'success',
                "Votre offre a bien été prise en compte.
                Vous pouvez retrouver le détail de vos contrats
                    en cours dans l'onglet Contractualisation."
            );

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
     * @param Contracts $contract The contract entity
     * @param Int $status Status value
     *
     * @route("/{id}/{status}", methods={"GET"},
     *     name="contract_status")
     *
     * @return Response A Response Instance
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
     * @param Contracts $contract The contract entity
     * @param Int $status Received status
     * @param MailerService $mailerUser Mailer service
     *
     * @route("/{id}/status/{status}", methods={"GET"},
     *     name="contract_status_mail")
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return Response A Response Instance
     */

    public function sendAction(Contracts $contract, int $status,
                               MailerService $mailerUser)
    {
        switch ($status) {

            case 2:
                $mailerUser->sendEmail(
                    $this->getUser()->getEmail(),
                    $contract->getOffer()->getActivity()->getOrganizationActivities()->getUser()->getEmail(),
                    'Validation',
                    'Une marque s\'est positionnée sur votre offre.'
                );
                //      Mail for the company
                $mailerUser->sendEmail(
                    $this->getUser()->getEmail(),
                    $contract->getOrganization()->getUser()->getEmail(),
                    'Validation',
                    'Une marque s\'est positionnée sur votre offre.'
                );
                break;

            case 3:
                $mailerUser->sendEmail(
                    $this->getUser()->getEmail(),
                    $contract->getOffer()->getActivity()->getOrganizationActivities()->getUser()->getEmail(),
                    'Payment',
                    'Une marque s\'est positionnée sur votre offre'
                );
                //      Mail for the company
                $mailerUser->sendEmail(
                    $this->getUser()->getEmail(),
                    $contract->getOrganization()->getUser()->getEmail(),
                    'Payment',
                    'Une marque s\'est positionnée sur votre offre'
                );
                break;

            case 4:
                $mailerUser->sendEmail(
                    $this->getUser()->getEmail(),
                    $contract->getOffer()->getActivity()->getOrganizationActivities()->getUser()->getEmail(),
                    'Offre expirée',
                    'Votre offre est expirée.'
                );
                //      Mail for the company
                $mailerUser->sendEmail(
                    $this->getUser()->getEmail(),
                    $contract->getOrganization()->getUser()->getEmail(),
                    'Payment',
                    'L\'offre sur laquelle vous vous êtes positionnées est malheureusement expirée.'
                );
        }
        return $this->redirectToRoute('manager_contract_list');
    }
}