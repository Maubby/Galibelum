<?php
/**
 * ActivityController File Doc Comment
 *
 * PHP version 7.1
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
        $em = $this->getDoctrine()->getManager();

        $activities = $em->getRepository('AppBundle:Activity')->findBy(
            array(
                'organizationActivities' => $this->getUser()->getOrganization()
            )
        );

        return $this->render(
            'activity/index.html.twig', array(
                'activities' => $activities,
            )
        );
    }

    /**
     * Creates a new activity entity.
     *
     * @param Request $request Delete posted info
     *
     * @Route("/new", methods={"GET", "POST"}, name="activity_new")
     *
     * @return Response A Response instance
     */
    public function newAction(Request $request)
    {
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity);
        $form->remove('uploadPdf');
        $organization = $this->getUser()->getOrganization();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $activity
                ->setOrganizationActivities($organization)
                ->setNameCanonical(strtolower($activity->getName()));

            $request->getSession()
                ->getFlashBag()
                ->add(
                    'pdf', "Vous pouvez ajouter un PDF pour décrire votre activité"
                );

            $em->persist($activity);
            $em->flush();

            return $this->redirectToRoute(
                'activity_edit',
                array('id' => $activity->getId())
            );
        }

        return $this->render(
            'activity/new.html.twig', array(
                'activity' => $activity,
                'form' => $form->createView(),
            )
        );
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
        $deleteForm = $this->_createDeleteForm($activity);
        $user = $this->getUser();

        return $this->render(
            'activity/show.html.twig', array(
                'activity' => $activity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @param Request             $request             Delete posted info
     * @param Activity            $activity            The activity entity
     * @param FileUploaderService $fileUploaderService Uploader Service
     *
     * @Route("/{id}/edit", methods={"GET", "POST"}, name="activity_edit")
     * @return              Response A Response instance
     */
    public function editAction(Request $request, Activity $activity,
        FileUploaderService $fileUploaderService
    ) {
        $fileName = $activity->getUploadPdf();
  
        $deleteForm = $this->_createDeleteForm($activity);
        $editForm = $this->createForm(ActivityType::class, $activity);
        $editForm->handleRequest($request);

        $user = $this->getUser();
        $organizationId = $user->getOrganization()->getId();

        // Var for the file name
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $activity->getUploadPdf();

            // Check if the file exist and set the new or old value
            if ($file !== null) {
                $filePdf = $fileUploaderService->upload(
                    $file, $organizationId, $activity->getId()
                );
            }

            $activity->setUploadPdf($filePdf);

            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Vos modifications ont bien été prises en compte.');

            return $this->redirectToRoute('dashboard_index');
        }


        return $this->render(
            'activity/edit.html.twig', array(
                'activity' => $activity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
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
        $form = $this->_createDeleteForm($activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($activity);
            $em->flush();
        }

        return $this->redirectToRoute('activity_index');
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
                    'activity_delete',
                    array('id' => $activity->getId())
                )
            )
            ->setMethod('DELETE')
            ->getForm();
    }
}