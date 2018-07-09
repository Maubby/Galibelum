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
        if ($this->getUser()->hasRole('ROLE_STRUCTURE')
            || $this->getUser()->hasRole('ROLE_COMPANY')
        ) {
            if ($this->getUser()->getOrganization()->getIsActive() === 0
            ) {
                return $this->redirectToRoute('waiting_index');
            } elseif ($this->getUser()->hasRole('ROLE_STRUCTURE')
            ) {
                return $this->redirectToRoute('dashboard_index');
            } else {
                return $this->redirectToRoute('search_index');
            }
        } elseif ($this->getUser()->hasRole('ROLE_SUPER_ADMIN')
            || $this->getUser()->hasRole('ROLE_MANAGER')
        ) {
            return $this->redirectToRoute('manager_contract_list');
        } else {
            return $this->redirectToRoute('inscription_index');
        }
    }
}