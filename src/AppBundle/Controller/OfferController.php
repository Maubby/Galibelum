<?php
/**
 * OfferController File Doc Comment
 *
 * PHP version 7.2
 *
 * @category OfferController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Activity;
use AppBundle\Entity\Offer;
use AppBundle\Service\ManagementFeesService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Offer controller.
 *
 * @Route("offer")
 *
 * @category OfferController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class OfferController extends Controller
{
    /**
     * Lists all offer entities.
     *
     * @Route("/", methods={"GET"}, name="offer_index")
     *
     * @return Response A Response instance
     */
    public function indexAction()
    {
        if ($this->getUser()->hasRole('ROLE_STRUCTURE')
            && $this->getUser()->getOrganization()->getIsActive() === 1
        ) {
            $em = $this->getDoctrine()->getManager();
            $event_activities = $em->getRepository('AppBundle:Activity')->findBy(
                [
                    'organizationActivities' => $this->getUser()->getOrganization(),
                    'type' => 'Évènement eSport',
                    'isActive' => true
                ]
            );
            $stream_activities = $em->getRepository('AppBundle:Activity')->findBy(
                [
                    'organizationActivities' => $this->getUser()->getOrganization(),
                    'type' => 'Activité de streaming',
                    'isActive' => true
                ]
            );
            $team_activities = $em->getRepository('AppBundle:Activity')->findBy(
                [
                    'organizationActivities' => $this->getUser()->getOrganization(),
                    'type' => 'Equipe eSport',
                    'isActive' => true
                ]
            );
            $editor_activities = $em->getRepository('AppBundle:Activity')->findBy(
                [
                    'organizationActivities' => $this->getUser()->getOrganization(),
                    'type' => 'Editeur de jeux',
                    'isActive' => true
                ]
            );
            $learn_activities = $em->getRepository('AppBundle:Activity')->findBy(
                [
                    'organizationActivities' => $this->getUser()->getOrganization(),
                    'type' => 'Formations gaming',
                    'isActive' => true
                ]
            );

            if (empty($event_activities) && empty($stream_activities)
                && empty($team_activities)
            ) {
                return $this->redirectToRoute('activity_new');
            }

            return $this->render(
                'offer/index.html.twig',
                [
                    'event_activities' => $event_activities,
                    'stream_activities' => $stream_activities,
                    'team_activities' => $team_activities,
                    'editor_activities' => $editor_activities,
                    'learn_activities' => $learn_activities,
                    'manager' => $this->getUser()->getOrganization()->getManagers(),
                ]
            );
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Creates a new offer entity and get information for current activity.
     *
     * @param Request               $request     New offer posted with activity id
     * @param Activity              $activity    New offer by activity
     * @param ManagementFeesService $feesService Fees Calculation services
     *
     * @Route("/{id}/new", methods={"GET", "POST"}, name="offer_new")
     *
     * @return Response A Response instance
     * @throws \Exception
     */
    public function newAction(Request $request, Activity $activity,
        ManagementFeesService $feesService
    ) {
        if ($this->getUser()->hasRole('ROLE_STRUCTURE')
            && $this->getUser()->getOrganization()->getIsActive() === 1
            && $activity->getIsActive() === true
        ) {
            if ($this->getUser()->getOrganization()->getOrganizationActivity()->isEmpty()
            ) {
                return $this->redirectToRoute('activity_new');
            }

            $offer = new Offer();
            $form = $this->createForm('AppBundle\Form\OfferType', $offer);
            $form->handleRequest($request);

            $interval = new \DateInterval(
                $this->getParameter('periode')
            );
            $fees = $feesService->getFees(
                $offer->getAmount()
            );

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $offer = $offer
                    ->setActivity($activity)
                    ->setNameCanonical($offer->getName())
                    ->setHandlingFee($fees)
                    ->setDate($offer->getDate()->sub($interval))
                    ->setPartnershipNb($form['partnershipNumber']->getData());
                $em->persist($offer);
                $em->flush();

                $this->addFlash(
                    'success',
                    "Votre offre a bien été créée."
                );
                return $this->redirectToRoute('offer_index');
            }

            return $this->render(
                'offer/new.html.twig',
                [
                    'offer' => $offer,
                    'activity' => $activity,
                    'manager' => $this->getUser()->getOrganization()->getManagers(),
                    'form' => $form->createView()
                ]
            );
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Displays a form to edit an existing offer entity.
     *
     * @param Request $request Edit posted info
     * @param Offer $offer The offer entity
     * @param ManagementFeesService $feesService Fees calculation service
     *
     * @return Response A Response instance
     * @Route("/{id}/edit",
     *     methods={"GET", "POST"}, name="offer_edit"
     * )
     *
     */
    public function editAction(Request $request, Offer $offer, ManagementFeesService $feesService)
    {
        $user = $this->getUser();
        if ($user->getOrganization()->getOrganizationActivity()->contains($offer->getActivity())
            && $offer->getIsActive() === true
        ) {
            $partnershipNb = $offer->countPartnershipNumber();
            $offer->setPartnershipNumber($partnershipNb);

            $fees = $feesService->getFees($offer->getAmount());
            $offer->setHandlingFee($fees);

            $deleteForm = $this->_createDeleteForm($offer);
            $editForm = $this->createForm('AppBundle\Form\OfferType', $offer);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $offer->setPartnershipNb($editForm['partnershipNumber']->getData());
                $offer->setHandlingFee($fees);
                $this->getDoctrine()->getManager()->persist($offer);
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash(
                    'success',
                    "Vos modifications ont bien été prises en compte."
                );

                return $this->redirectToRoute(
                    'dashboard_index',
                    ['id' => $offer->getId()]
                );
            }

            return $this->render(
                'offer/edit.html.twig',
                [
                    'offer' => $offer,
                    'manager' => $this->getUser()->getOrganization()->getManagers(),
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView()
                ]
            );
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Deletes an offer entity.
     *
     * @param Request $request Delete posted info
     * @param Offer   $offer   The offer entity
     *
     * @Route("/{id}", methods={"DELETE"}, name="offer_delete")
     *
     * @return Response A Response instance
     */
    public function deleteAction(Request $request, Offer $offer)
    {
        $user = $this->getUser();
        if ($user->getOrganization()->getOrganizationActivity()->contains($offer->getActivity())
            && $offer->getIsActive() === true
        ) {
            $form = $this->_createDeleteForm($offer);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()
                && $offer->getContractExpirate()
            ) {
                $em = $this->getDoctrine()->getManager();
                $offer->setIsActive(false);
                $em->persist($offer);
                $em->flush();

                $this->addFlash(
                    'success',
                    "L'offre a bien été supprimée."
                );
            } else {
                $this->addFlash(
                    'danger',
                    "Vous ne pouvez pas supprimer cette offre car une
                    marque s'est déjà positionnée sur celle-ci."
                );
            }
            return $this->redirectToRoute('offer_index');
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Creates a form to delete an offer entity.
     *
     * @param Offer $offer The offer entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function _createDeleteForm(Offer $offer)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'offer_delete',
                    ['id' => $offer->getId()]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
    }
}