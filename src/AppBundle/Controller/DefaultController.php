<?php
/**
 * DefaultController File Doc Comment
 *
 * PHP version 7.2
 *
 * @category DefaultController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Default controller.
 *
 * @Route("redirect")
 *
 * @category AdminController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class DefaultController extends Controller
{
    /**
     * Redirect when customers have an access denied
     *
     * @Route("/", methods={"GET"}, name="redirect")
     * @return     Response A Response instance
     */
    public function redirectAction()
    {
        $user = $this->getUser();

        if ($user->hasRole('ROLE_STRUCTURE')
            && $user->getOrganization()->getIsActive() === 1)
        {
            return $this->redirectToRoute('dashboard_index');

        } elseif ($user->hasRole('ROLE_STRUCTURE')
            && $user->getOrganization()->getIsActive() === 0
            || $user->hasRole('ROLE_COMPANY')
            && $user->getOrganization()->getIsActive() === 0
        ) {
            return $this->redirectToRoute('waiting_index');

        } elseif ($user->hasRole('ROLE_COMPANY')
            && $user->getOrganization()->getIsActive() === 1
        ) {
            return $this->redirectToRoute('search_index');

        } elseif ($user->hasRole('ROLE_MANAGER')) {
            return $this->redirectToRoute('manager_index');

        } elseif ($user->hasRole('ROLE_SUPER_ADMIN')) {
            return $this->redirectToRoute('admin_index');

        } else {
            return $this->redirectToRoute('inscription_index');
        }
    }
}