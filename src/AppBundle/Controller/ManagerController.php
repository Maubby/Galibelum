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
use AppBundle\Entity\User;
use AppBundle\Entity\Organization;
use AppBundle\Form\ContractType;
use AppBundle\Service\FileUploaderService;
use AppBundle\Service\MailerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/organization", methods={"GET"},
     *     name="manager_organization_list")
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
            'manager/index.html.twig',
            ['organizations' => $organizations]
        );
    }

    /**
     * Activates an organization entity.
     *
     * @param Organization  $organization The organization entity
     * @param MailerService $mailerUser   The mailer service
     *
     * @Route("/activate/{id}", methods={"GET"},
     *     name="manager_organization_activate")
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return Response A Response Instance
     */
    public function activateAction(Organization $organization,
        MailerService $mailerUser
    ) {
        $organization->setIsActive(1)
            ->getUser()->setEnabled(true);
        $organization->setManagers($this->getUser());
        $this->getDoctrine()->getManager()->persist($organization);
        $this->getDoctrine()->getManager()->flush();

        $mailerUser->sendEmail(
            $this->getParameter('mailer_user'),
            $organization->getUser()->getEmail(),
            'Galibelum - Activation de votre compte',
            'Votre organisation vient d\'être validée par l\'un
            de nos accounts managers.
            Vous pouvez dès à présent vous rendre sur le site.'
        );
        return $this->redirectToRoute('manager_organization_list');
    }

    /**
     * Disable one organization.
     *
     * @param Organization  $organization The organization entity
     * @param MailerService $mailerUser   The mailer service
     *
     * @route("/disable/{id}", methods={"GET"},
     *     name="manager_organization_disable")
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return Response A Response Instance
     */
    public function disableAction(Organization $organization,
        MailerService $mailerUser
    ) {
        $organization->setIsActive(2)
            ->getUser()->setEnabled(false);
        $this->getDoctrine()->getManager()->persist($organization);
        $this->getDoctrine()->getManager()->flush();

        $mailerUser->sendEmail(
            $this->getParameter('mailer_user'),
            $organization->getUser()->getEmail(),
            'Galibelum - Désactivation de votre compte',
            'Votre organisation vient d\'être désactivée par l\'un
            de nos accounts managers.
            Pour plus d\'information veuillez contacter l\'équipe Galibelum au 
            03 74 09 50 88.'
        );
        return $this->redirectToRoute('manager_organization_list');
    }

    /**
     * Lists all contracts.
     *
     * @Route("/contract", methods={"GET"},
    name="manager_contract_list")
     *
     * @return Response A Response instance
     */
    public function contractAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organizations = $em->getRepository('AppBundle:Organization')->findby(
            [
                'managers' => $this->getUser(),
                'user' => $em
                    ->getRepository('AppBundle:User')
                    ->findByRole('ROLE_COMPANY'),
            ]
        );
        $contracts = $em->getRepository('AppBundle:Contracts')->findBy(
            ['organization' => $organizations]
        );

        return $this->render(
            'manager/contract.html.twig',
            ['contracts' => $contracts]
        );
    }

    /**
     * Lists all contracts.
     *
     * @param Request             $request             New posted info
     * @param Contracts           $contract            The contract entity
     * @param FileUploaderService $fileUploaderService The upload service
     *
     * @Route("/{contract}/upload",
     *     methods={"POST"}, name="contract_upload")
     *
     * @return Response
     */
    public function uploadAction(Request $request, Contracts $contract,
        FileUploaderService $fileUploaderService
    ) {
        $form = $this->createForm(ContractType::class);
        $form->remove('finalDeal');
        $form->handleRequest($request);

        // Var for the file name
        if ($form->isSubmitted() && $form->isValid()) {
            $filePdf = [];

            foreach ($request->files->get("appbundle_contract")['uploadPdf']
                     as $file
            ) {
                $offer = $contract->getOffer();
                $activity = $offer->getActivity();
                $organization = $activity->getOrganizationActivities();

                // Check if the file exist and set the new or old value
                $filePdf[] = $fileUploaderService->upload(
                    $file, $organization->getId(),
                    $activity->getId(), $offer->getId()
                );

                $this->addFlash(
                    'success',
                    "Vos modifications ont bien été prises en compte."
                );

                $contract->setUploadPdf($filePdf);
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('manager_contract_list');
        }

        return $this->render(
            'manager/_uploadContract.html.twig',
            [
                'form' => $form->createView(),
                'contract' => $contract
            ]
        );
    }

    /**
     * Deletes pdf
     *
     * @param FileUploaderService $fileUploaderService The Upload Pdf Service.
     * @param Contracts $contract The contract entity.
     * @param string $fileName The pdf name.
     *
     * @Route("/{contract}/{fileName}/delete", methods={"GET"},
     *      name="contract_pdf_delete")
     *
     * @return Response A Response instance
     */
    public function deletePdfAction(FileUploaderService $fileUploaderService,
        Contracts $contract, string $fileName
    ) {
        $offer = $contract->getOffer();
        $activity = $offer->getActivity();
        $organization = $activity->getOrganizationActivities();
        $fileUploaderService->deletePdf(
            $fileName,
            $organization->getId(),
            $activity->getId(),
            $offer->getId()
        );

        $contract->removePdf($fileName);
        $this->getDoctrine()->getManager()->persist($contract);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash(
            'success',
            "Le PDF a bien été supprimé."
        );

        return $this->redirectToRoute('manager_contract_list');
    }

    /**
     * Lists all contracts.
     *
     * @param Request   $request  New posted info
     * @param Contracts $contract The contract entity
     *
     * @Route("/{contract}",
     *     methods={"POST"}, name="contract_final_deal")
     *
     * @return Response
     */
    public function finalDealAction(Request $request, Contracts $contract)
    {
        $form = $this->createForm(ContractType::class);
        $form->remove('uploadPdf');
        $form->handleRequest($request);

        // Var for the file name
        if ($form->isSubmitted() && $form->isValid()) {
            $contract->setFinalDeal(
                $request->get("appbundle_contract")['finalDeal']
            );
            $this->getDoctrine()->getManager()->persist($contract);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('manager_contract_list');
        }

        return $this->render(
            'manager/_finalDealContract.html.twig',
            [
                'form' => $form->createView(),
                'contract' => $contract
            ]
        );
    }

    /**
     * Lists all organization entities.
     *
     * @Route("/user", methods={"GET"},
     *     name="manager_user_list")
     *
     * @return Response A Response instance
     */
    public function userListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em
            ->getRepository('AppBundle:User')
            ->findAll();

        return $this->render(
            'manager/user.html.twig', array(
                'users' => $users
            )
        );
    }

    /**
     * Resend an email entity.
     *
     * @param User $user Entity User
     *
     * @return              Response A Response Instance
     * @Route("/send/{id}", methods={"GET"},
     *     name="manager_user_resend")
     */
    public function resendConfirmation(User $user)
    {
        $mailer = $this->get('fos_user.mailer');
        $mailer->sendConfirmationEmailMessage($user);

        $this->addFlash('success', 'Confirmation d\'email envoyée');
        return $this->redirectToRoute('manager_user_list');
    }
}