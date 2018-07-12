<?php
/**
 * ActivityController File Doc Comment
 *
 * PHP version 7.2
 *
 * @category ActivityController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Activity;
use AppBundle\Form\ActivityType;
use AppBundle\Service\FileUploaderService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Activity controller.
 *
 * @Route("activity")
 *
 * @category ActivityController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class ActivityController extends Controller
{
    /**
     * Lists all activity entities.
     *
     * @Route("/", methods={"GET"}, name="activity_index")
     *
     * @return Response A Response instance
     */
    public function indexAction()
    {
        if ($this->getUser()->hasRole('ROLE_STRUCTURE')
            && $this->getUser()->getOrganization()->getIsActive() === 1
        ) {
            if ($this->getUser()->getOrganization()->getOrganizationActivity()->isEmpty()) {
                return $this->redirectToRoute('activity_new');
            }
            $em = $this->getDoctrine()->getManager();
            $activities = $em->getRepository('AppBundle:Activity')->findBy(
                array(
                    'organizationActivities' => $this->getUser()->getOrganization(),
                    'isActive' => true
                )
            );

            return $this->render(
                'activity/index.html.twig', array(
                    'activities' => $activities
                )
            );
        }
        return $this->redirectToRoute('redirect');

    }

    /**
     * Creates a new activity entity.
     *
     * @param Request $request New posted info
     *
     * @Route("/new", methods={"GET", "POST"}, name="activity_new")
     *
     * @return Response A Response instance
     */
    public function newAction(Request $request)
    {
        if ($this->getUser()->hasRole('ROLE_STRUCTURE')
            && $this->getUser()->getOrganization()->getIsActive() === 1
        ) {
            $activity = new Activity();
            $form = $this->createForm(ActivityType::class, $activity);
            $form->remove('uploadPdf');
            $organization = $this->getUser()->getOrganization();
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $activity
                    ->setOrganizationActivities($organization)
                    ->setNameCanonical($activity->getName());

                $this->addFlash(
                    'pdf',
                    "Vous pouvez ajouter un PDF pour décrire votre activité"
                );
                $em->persist($activity);
                $em->flush();

                return $this->redirectToRoute(
                    'activity_edit', array(
                        'id' => $activity->getId()
                    )
                );
            }

            return $this->render(
                'activity/new.html.twig', array(
                    'activity' => $activity,
                    'form' => $form->createView()
                )
            );
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Finds and displays a activity entity.
     *
     * @param Activity $activity The activity entity
     *
     * @Route("/{id}", methods={"GET", "POST"}, name="activity_show")
     *
     * @return Response A Response instance
     */
    public function showAction(Activity $activity)
    {
        if ($this->getUser()->hasRole('ROLE_STRUCTURE')
            && $this->getUser()->getOrganization()->getIsActive() === 1
            || $this->getUser()->hasRole('ROLE_COMPANY')
            && $this->getUser()->getOrganization()->getIsActive() === 1
        ) {
            return $this->render(
                'activity/show.html.twig', array(
                    'activity' => $activity
                )
            );
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @param Request             $request             Edit posted info
     * @param Activity            $activity            The activity entity
     * @param FileUploaderService $fileUploaderService Uploader Service
     *
     * @Route("/{id}/edit", methods={"GET", "POST"}, name="activity_edit")
     * @return              Response A Response instance
     */
    public function editAction(Request $request, Activity $activity,
                               FileUploaderService $fileUploaderService
    ) {
        $user = $this->getUser();
        if ($user->getOrganization()->getOrganizationActivity()->contains($activity)
            && $activity->getIsActive() === true
        ) {
            $fileName = $activity->getUploadPdf();

            $deleteForm = $this->_createDeleteForm($activity);
            $editForm = $this->createForm(ActivityType::class, $activity);
            $editForm->handleRequest($request);

            $organizationId = $this->getUser()->getOrganization()->getId();

            // Var for the file name
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $file = $activity->getUploadPdf();

                // Check if the file exist and set the new or old value
                $filePdf = $file!=null ? $filePdf = $fileUploaderService->upload(
                    $file, $organizationId, $activity->getId()
                ) : $fileName;

                $this->addFlash(
                    'success',
                    "Vos modifications ont bien été prises en compte."
                );
                $activity->setUploadPdf($filePdf);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('dashboard_index');
            }

            return $this->render(
                'activity/edit.html.twig', array(
                    'activity' => $activity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView()
                )
            );
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Deletes a activity entity.
     *
     * @param Request  $request  Delete posted info
     * @param Activity $activity The activity entity
     *
     * @Route("/{id}", methods={"DELETE"}, name="activity_delete")
     *
     * @return Response A Response instance
     */
    public function deleteAction(Request $request, Activity $activity)
    {
        $user = $this->getUser();
        if ($user->getOrganization()->getOrganizationActivity()->contains($activity)
        ) {
            $form = $this->_createDeleteForm($activity);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid() && $activity->getActivities()->isEmpty()) {
                $em = $this->getDoctrine()->getManager();
                $activity->setIsActive(false);
                $em->persist($activity);
                $em->flush();

                $this->addFlash(
                    'success',
                    "L'activité a bien étè supprimée."
                );
            } else {
                $this->addFlash(
                    'danger',
                    "Vous ne pouvez pas supprimer cette activité car des offres sont liées a l'activité."
                );
            }
            return $this->redirectToRoute('activity_index');
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Creates a form to delete a activity entity.
     *
     * @param Activity $activity The activity entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function _createDeleteForm(Activity $activity)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'activity_delete', array(
                        'id' => $activity->getId()
                    )
                )
            )
            ->setMethod('DELETE')
            ->getForm();
    }
}