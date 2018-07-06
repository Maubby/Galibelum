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
        if ($this->getUser()->hasRole('ROLE_MANAGER')
            || $this->getUser()->hasRole('ROLE_SUPER_ADMIN')
        ) {
            return $this->redirectToRoute('manager_contract_list');
        }

        $em = $this->getDoctrine()->getManager();

        $offers = $em
            ->getRepository('AppBundle:Offer')
            ->findBy(
                array(
                    'organization' => $this->getUser()->getOrganization()
                )
            );

        $event_activities = $em->getRepository('AppBundle:Activity')->findBy(
            array(
                'organizationActivities' => $this->getUser()->getOrganization(),
                'type' => 'Évènement eSport'
            )
        );

        $stream_activities = $em->getRepository('AppBundle:Activity')->findBy(
            array(
                'organizationActivities' => $this->getUser()->getOrganization(),
                'type' => 'Activité de streaming'
            )
        );

        $team_activities = $em->getRepository('AppBundle:Activity')->findBy(
            array(
                'organizationActivities' => $this->getUser()->getOrganization(),
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
     * @Route("/{id}/new", methods={"GET", "POST"}, name="offer_new")
     *
     * @return Response A Response instance
     * @throws \Exception
     */
    public function newAction(Request $request, Activity $activity,
                              ManagementFeesService $feesService
    ) {
        if ($this->getUser()->hasRole('ROLE_MANAGER')
            || $this->getUser()->hasRole('ROLE_SUPER_ADMIN')
        ) {
            return $this->redirectToRoute('manager_contract_list');
        }

        $offer = new Offer();
        $form = $this->createForm('AppBundle\Form\OfferType', $offer);
        $form->handleRequest($request);
        $interval = new \DateInterval($this->getParameter('periode'));

        $fees = $feesService->getFees($offer->getAmount(), $offer->getFinalDeal());

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $offer = $offer
                ->setActivity($activity)
                ->setNameCanonical(strtolower($activity->getName()))
                ->setHandlingFee($fees)
                ->setDate($offer->getDate()->sub($interval));

            $em->persist($offer);
            $em->flush();

            return $this->redirectToRoute(
                'offer_show', array(
                    'id' => $offer->getId(),
                )
            );
        }

        return $this->render(
            'offer/new.html.twig', array(
                'offer' => $offer,
                'activity' => $activity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing offer entity.
     *
     * @param Request $request Edit posted info
     * @param Offer   $offer   The offer entity
     *
     * @Route("/{id}/edit", methods={"GET", "POST"}, name="offer_edit")
     *
     * @return Response A Response instance
     */
    public function editAction(Request $request, Offer $offer)
    {
        if ($this->getUser()->hasRole('ROLE_MANAGER')
            || $this->getUser()->hasRole('ROLE_SUPER_ADMIN')
        ) {
            return $this->redirectToRoute('manager_contract_list');
        }

        $user = $this->getUser();
        if ($user->getOrganization()->getOrganizationActivity()->contains($offer->getActivity())
        ) {
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

        return $this->redirectToRoute('redirect');
    }

    /**
     * Displays a form to edit an existing offer entity.
     *
     * @param Offer   $offer   The offer entity
     *
     * @Route("/{id}/relation", methods={"GET", "POST"}, name="offer_relation")
     *
     * @return Response A Response instance
     */
    public function relationAction(Offer $offer)
    {

        $user = $this->getUser();

            $em = $this->getDoctrine()->getManager();
            $offer->setStatus(1)
                ->addContract($user->getOrganization());
            $em->persist($offer);
            $em->flush();



            return $this->render(
                'activity/show.html.twig', array(
                    'activity' => $offer->getActivity(),
                )
            );

    }

    /**
     * Displays a form to edit an existing offer entity.
     *
     * @param Offer   $offer   The offer entity
     *
     * @Route("/{id}/partners", methods={"GET", "POST"}, name="offer_relation")
     *
     * @return Response A Response instance
     */
    public function partnersAction(Offer $offer)
    {

        $user = $this->getUser();

            $em = $this->getDoctrine()->getManager();
            $offer->setStatus(1)
                ->addContract($user->getOrganization());
            $em->persist($offer);
            $em->flush();



            return $this->render(
                'activity/show.html.twig', array(
                    'activity' => $offer->getActivity(),
                )
            );

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
        if ($this->getUser()->hasRole('ROLE_MANAGER')
            || $this->getUser()->hasRole(
                'ROLE_SUPER_ADMIN'
            )
        ) {
            return $this->redirectToRoute('manager_contract_list');
        }

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
                    'offer_delete', array(
                        'id' => $offer->getId())
                )
            )
            ->setMethod('DELETE')
            ->getForm();
    }
}