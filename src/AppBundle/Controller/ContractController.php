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
        if ($this->getUser()->hasRole('ROLE_STRUCTURE')
            && $this->getUser()->getOrganization()->getIsActive() === 1
            || $this->getUser()->hasRole('ROLE_COMPANY')
            && $this->getUser()->getOrganization()->getIsActive() === 1
        ) {
            $em = $this->getDoctrine()->getManager();

            if ($this->getUser()->hasRole('ROLE_COMPANY')) {
                $contracts = $em->getRepository('AppBundle:Contracts')->findBy(
                    ['organization' => $this->getUser()->getOrganization()]
                );
            } elseif ($this->getUser()->hasRole('ROLE_STRUCTURE')) {

                $activities = $em->getRepository('AppBundle:Activity')->findby(
                    [
                        'organizationActivities' => $this->getUser()
                            ->getOrganization(),
                    ]
                );

                $offers = $em->getRepository('AppBundle:Offer')->findby(
                    ['activity' => $activities,]
                );
                $contracts = $em->getRepository('AppBundle:Contracts')->findBy(
                    ['offer' => $offers,]
                );
            }

            return $this->render(
                'contractualisation/index.html.twig',
                [
                    'contracts' => $contracts,
                    'manager' => $this->getUser()->getOrganization()->getManagers(),
                ]
            );
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Set contract when company click to relation button.
     *
     * @param Offer         $offer      The offer entity
     * @param MailerService $mailerUser The mailer service
     *
     * @Route("/{id}/partners", methods={"GET", "POST"},
     *     name="contract_relation")
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

            if (in_array(
                $this->getUser()->getOrganization()->getId(),
                $offer->getPact()
            )
            ) {
                return $this->redirectToRoute(
                    'activity_show',
                    ['id' => $offer->getActivity()->getId()]
                );
            }

            $contract = new Contracts();
            $contract
                ->setStatus(1)
                ->setOffer($offer)
                ->setOrganization($this->getUser()->getOrganization());
            $this->getDoctrine()->getManager()->persist($contract);
            $this->getDoctrine()->getManager()->flush();

            $mailerUser->sendEmail(
                $this->getParameter('mailer_user'),
                $offer->getActivity()->getOrganizationActivities()
                    ->getUser()->getEmail(),
                'Galibelum - Mise en relation',
                'La marque <strong>'.$this->getUser()->getOrganization()->getName().
                '</strong> s\'intéresse à l\'offre <strong>'.$offer->getName().
                '</strong> liée à votre activité 
                <strong>'.$offer->getActivity()->getName().'</strong>.
                <br>
                <br>
                Vous venez d\'entrer dans la phase de négociation.
                Vous pourrez ainsi échanger avec la structure eSport
                afin de trouver un accord.
                <br>
                <br>
                Votre account manager reviendra vers vous dans
                les meilleurs délais afin de vous accompagner 
                durant cette phase de négociation puis dans les étapes suivantes.'
            );

            $mailerUser->sendEmail(
                $this->getParameter('mailer_user'),
                $contract->getOrganization()->getUser()->getEmail(),
                'Galibelum - Mise en Relation',
                'Vous avez souhaité être mis en relation avec <strong>'
                .$offer->getActivity()->getOrganizationActivities()->getName().
                '</strong> au sujet de l\'offre <strong>'.$offer->getName().
                '</strong> liée à l\'activité <strong>'
                .$offer->getActivity()->getName().'</strong>.
                <br>
                <br>
                Vous venez d\'entrer dans la phase de négociation.
                Vous pourrez ainsi échanger avec la structure eSport
                afin de trouver un accord.
                <br>
                <br>
                Votre account manager reviendra vers vous dans les
                meilleurs délais afin de vous accompagner 
                durant cette phase de négociation puis dans les étapes suivantes.'
            );

            $mailerUser->sendEmail(
                $this->getParameter('mailer_user'),
                $contract->getOrganization()->getManagers()->getEmail(),
                'Galibelum - Mise en relation',
                'La marque <strong>'.$this->getUser()->getOrganization()->getName().
                '</strong> souhaite se mettre en relation avec la structure <strong>'
                .$offer->getActivity()->getOrganizationActivities()->getName().
                '</strong> au sujet de l\'offre 
                <strong>'.$offer->getName().'</strong> liée à l\'activité <strong>'
                .$offer->getActivity()->getName().'</strong>.'
            );

            $this->addFlash(
                'success',
                "Votre offre a bien été prise en compte.
                Vous pouvez retrouver le détail de vos contrats
                    en cours dans l'onglet Contractualisation."
            );

            return $this->redirectToRoute(
                'activity_show',
                ['id' => $offer->getActivity()->getId()]
            );
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Changes contracts' status.
     *
     * @param Contracts $contract The contract entity
     * @param Int       $status   Status value
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
     * @param Contracts     $contract   The contract entity
     * @param Int           $status     Received status
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
        MailerService $mailerUser
    ) {
        switch ($status) {
        case 2:
            $mailerUser->sendEmail(
                $this->getParameter('mailer_user'),
                $contract->getOffer()->getActivity()
                    ->getOrganizationActivities()->getUser()->getEmail(),
                'Galibelum - Validation',
                'Félicitations, un accord avec 
                <strong>'.$contract->getOrganization()->getName().
                '</strong> pour votre offre <strong>'
                .$contract->getOffer()->getName().
                '</strong> reliée à l\'activité <strong>'
                .$contract->getOffer()->getActivity()->getName().
                '</strong> a été trouvé.
                <br>
                <br>
                Vous entrez ainsi en phase de validation.
                Vous retrouverez prochainement les contrats
                signés et téléchargeables depuis la plateforme Galibelum.',
                $contract->getOrganization()->getManagers()->getPhoneNumber(),
                $contract->getOrganization()->getManagers()->getEmail()
            );

            $mailerUser->sendEmail(
                $this->getParameter('mailer_user'),
                $contract->getOrganization()->getUser()->getEmail(),
                'Galibelum - Validation',
                'Félicitations, un accord avec <strong>'.
                $contract->getOffer()
                    ->getActivity()
                    ->getOrganizationActivities()
                    ->getName().
                '</strong> pour l\'offre <strong>'.$contract->getOffer()->getName().
                '</strong> reliée à l\'activité <strong>'
                .$contract->getOffer()->getActivity()->getName().
                '</strong> a été trouvé.
                <br>
                <br>
                Vous entrez ainsi en phase de validation.
                Vous retrouverez prochainement les contrats
                signés et téléchargeables depuis la plateforme Galibelum.',
                $contract->getOrganization()->getManagers()->getPhoneNumber(),
                $contract->getOrganization()->getManagers()->getEmail()
            );
            break;

        case 3:
            $mailerUser->sendEmail(
                $this->getParameter('mailer_user'),
                $contract->getOffer()->getActivity()
                    ->getOrganizationActivities()->getUser()->getEmail(),
                'Galibelum - Paiement',
                'Félicitations, le paiement pour l\'offre 
                <strong>'.$contract->getOffer()->getName(). '</strong>
                est en cours.
                <br>
                <br>
                Nous vous remercions d\'avoir choisi Galibelum pour
                réaliser votre projet.',
                $contract->getOrganization()->getManagers()->getPhoneNumber(),
                $contract->getOrganization()->getManagers()->getEmail()
            );
            //      Mail for the company
            $mailerUser->sendEmail(
                $this->getParameter('mailer_user'),
                $contract->getOrganization()->getUser()->getEmail(),
                'Galibelum - Paiement',
                'Vous pouvez désormais effectuer le paiement pour l\'offre 
                <strong>'.$contract->getOffer()->getName(). '</strong>.
                <br>
                <br>
                Nous vous remercions d\'avoir choisi Galibelum pour
                réaliser votre projet.',
                $contract->getOrganization()->getManagers()->getPhoneNumber(),
                $contract->getOrganization()->getManagers()->getEmail()
            );
            break;
        }
        return $this->redirectToRoute('manager_contract_list');
    }
}
