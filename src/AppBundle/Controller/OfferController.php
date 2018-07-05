<?php
/**
 * OfferController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category OfferController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Activity;
use AppBundle\Entity\Offer;
use AppBundle\Service\ManagementFeesService;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @Route("/",    name="offer_index")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $offers = $em
            ->getRepository('AppBundle:Offer')
            ->findBy(
                array(
                    'organization' => $user->getOrganization()
                )
            );

        $event_activities = $em->getRepository('AppBundle:Activity')->findBy(
            array(
                'organizationActivities' => $user->getOrganization(),
                'type' => 'Évènement eSport'
            )
        );

        $stream_activities = $em->getRepository('AppBundle:Activity')->findBy(
            array(
                'organizationActivities' => $user->getOrganization(),
                'type' => 'Activité de streaming'
            )
        );

        $team_activities = $em->getRepository('AppBundle:Activity')->findBy(
            array(
                'organizationActivities' => $user->getOrganization(),
                'type' => 'Equipe eSport'
            )
        );

        return $this->render(
            'offer/index.html.twig', array(
                'offers' => $offers,
                'event_activities' => $event_activities,
                'stream_activities' => $stream_activities,
                'team_activities' => $team_activities,
            )
        );
    }

    /**
     * Creates a new offer entity and get information for current activity.
     *
     * @param Request               $request     New offer posted with activity id
     * @param Activity              $activity    New offer by activity
     * @param ManagementFeesService $feesService Fees Calculation services
     *
     * @Route("/{id}/new",     name="offer_new")
     * @Method({"GET","POST"})
     *
     * @return Response A Response instance
     * @throws \Exception
     */
    public function newAction(Request $request, Activity $activity,
                              ManagementFeesService $feesService
    ) {
        $offer = new Offer();
        $form = $this->createForm('AppBundle\Form\OfferType', $offer);
        $form->handleRequest($request);
        $interval = new \DateInterval($this->getParameter('periode'));

        $user = $this->getUser();
        $fees = $feesService->getFees($offer->getAmount(), $offer->getFinalDeal());

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $offer = $offer
                ->setActivity($activity)
                ->setNameCanonical(strtolower($activity->getName()))
                ->setHandlingFee($fees)
                ->setOrganization($user->getOrganization())
                ->setDate($offer->getDate()->sub($interval));

            $em->persist($offer);
            $em->flush();

            return $this->redirectToRoute(
                'offer_show', array(
                    'id' => $offer->getId())
            );
        }

        return $this->render(
            'offer/new.html.twig', array(
                'offer' => $offer,
                'activity'=> $activity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays all offer's from search result.
     *
     * @param Offer $offer The offer entity
     * @param Swift_Mailer $mailer
     *
     * @return Response A Response instance
     * @Route("/{id}", name="offer_relation")
     * @Method("GET")
     */
    public function relationAction(Offer $offer, Swift_Mailer $mailer)
    {
        $user = $this->getUser();

        if ($user->hasRole('ROLE_STRUCTURE' && $user->getOrganization()->getIsActive() === 1)) {

            $offer->setOrganization($user->getOrganization());
            $this->getDoctrine()->getManager()->flush();

            $message = (new Swift_Message('Hello Email'))
                ->setFrom('contact@galibelum.fr')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'offer/email.txt.twig'),
                    'text/plain'
                );

            $mailer->send($message);

            return $this->redirectToRoute(
                'activity_show', array(
                    'id' => $offer->getId()
                )
            );
        }

        return $this->redirectToRoute('dashboard_index');
    }

    /**
     * Displays a form to edit an existing offer entity.
     *
     * @param Request $request Edit posted info
     * @param Offer   $offer   The offer entity
     *
     * @Route("/{id}/edit", name="offer_edit")
     * @Method({"GET",      "POST"})
     *
     * @return Response A Response instance
     */
    public function editAction(Request $request, Offer $offer)
    {
        $deleteForm = $this->_createDeleteForm($offer);
        $editForm = $this->createForm('AppBundle\Form\OfferType', $offer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(
                'offer_edit', array(
                    'id' => $offer->getId())
            );
        }

        return $this->render(
            'offer/edit.html.twig', array(
                'offer' => $offer,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a offer entity.
     *
     * @param Request $request Delete posted info
     * @param Offer   $offer   The offer entity
     *
     * @Route("/{id}",   name="offer_delete")
     * @Method("DELETE")
     *
     * @return Response A Response instance
     */
    public function deleteAction(Request $request, Offer $offer)
    {
        $form = $this->_createDeleteForm($offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($offer);
            $em->flush();
        }

        return $this->redirectToRoute('offer_index');
    }

    /**
     * Creates a form to delete a offer entity.
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
                    'offer_delete', array(
                        'id' => $offer->getId())
                )
            )
            ->setMethod('DELETE')
            ->getForm();
    }
}
