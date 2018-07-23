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
     * @param Request $request New posted info
     *
     * @return Response A Response instance
     */
    public function editAction(Request $request)
    {
        if (!is_object($this->getUser())
            || !$this->getUser() instanceof UserInterface
        ) {
            throw new AccessDeniedException(
                'Vous n\'avez pas accès à cette page.'
            );
        }

        /**
         * Two forms, one on profile editing and the other one on password
         *
         * @var $formFactory FactoryInterface
         */
        $formFactory = $this->get('fos_user.profile.form.factory');
        $form = $formFactory->createForm();
        $form->setData($this->getUser());

        $formFactoryPassword = $this->get('fos_user.change_password.form.factory');
        $formPassword = $formFactoryPassword->createForm();
        $formPassword->setData($this->getUser());

        $form->handleRequest($request);
        $formPassword->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * If profile submitted & valid
             *
             * @var $userManager UserManagerInterface
             */
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($this->getUser());

            $url = $this->generateUrl('redirect');
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
            $userManager->updateUser($this->getUser());

            $url = $this->generateUrl('redirect');
            $response = new RedirectResponse($url);

            $this->addFlash(
                "edited",
                "Votre nouveau mot de passe a bien été pris en compte."
            );
            return $response;
        }

        $manager = $this->getUser()->getOrganization() != null
            ? $this->getUser()->getOrganization()->getManagers()
            : null;

        return $this->render(
            '@FOSUser/Profile/edit.html.twig',
            [
                'form' => $form->createView(),
                'formPassword' => $formPassword->createView(),
                'user' => $this->getUser(),
                'manager' => $manager,
            ]
        );
    }
}