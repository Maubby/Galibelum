<?php
/**
 * Profile controller based on FOSUser
 *
 * PHP Version 7.2
 *
 * @category Controller
 * @package  FOSUserController
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Overriding controller managing the user profile.
 *
 * @category Controller
 * @package  FOSUserController
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class ProfileController extends BaseController
{
    /**
     * Constructor method
     */
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     *
     * @return Response A Response instance
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException(
                'This user does not have access to this section.'
            );
        }

        return $this->render(
            '@FOSUser/Profile/show.html.twig', array(
                'user' => $user,
            )
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param Request $request New posted info
     *
     * @return Response A Response instance
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException(
                'This user does not have access to this section.'
            );
        }

        /**
         * Two forms, one on profile editing and the other one on password
         *
         * @var $formFactory FactoryInterface
         */
        $formFactory = $this->get('fos_user.profile.form.factory');
        $form = $formFactory->createForm();
        $form->setData($user);

        $formFactoryPassword = $this->get('fos_user.change_password.form.factory');
        $formPassword = $formFactoryPassword->createForm();
        $formPassword->setData($user);

        $form->handleRequest($request);
        $formPassword->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * If profile submitted & valid
             *
             * @var $userManager UserManagerInterface
             */
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            $url = $this->generateUrl('fos_user_profile_show');
            $response = new RedirectResponse($url);

            $this->addFlash(
                "edited",
                "Votre profil a bien été modifié."
            );
            return $response;
        }
        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            /**
             * If submitted & valid new password edited
             *
             * @var $userManager UserManagerInterface
             */
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            $url = $this->generateUrl('fos_user_profile_show');
            $response = new RedirectResponse($url);

            $this->addFlash(
                "edited",
                "Votre nouveau mot de passe a bien été pris en compte."
            );

            return $response;
        }

        return $this->render(
            '@FOSUser/Profile/edit.html.twig', array(
                'form' => $form->createView(),
                'formPassword' => $formPassword->createView(),
                'user' => $user,
            )
        );
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/profile/delete/", methods={"GET"}, name="profile_delete")
     *
     * @return Response A Response instance
     */
    public function deleteUser()
    {
        $user = $this->getUser();
        if ($user->hasRole('ROLE_USER')) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            $this->addFlash('danger', 'Votre compte a bien été supprimé.');
            return $this->redirectToRoute('homepage');
        } else {
            return $this->redirectToRoute('fos_user_profile_show');
        }
    }
}