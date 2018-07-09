<?php
/**
 * OfferController File Doc Comment
 *
 * PHP version 7.2
 *
 * @category InscriptionController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Inscription controller.
 *
 * @Route("inscription")
 *
 * @category InscriptionController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class InscriptionController extends Controller
{
    /**
     * Inscription choose Company & Organization
     *
     * @Route("/", methods={"GET"}, name="inscription_index")
     *
     * @return Response A Response instance
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if ($user->hasRole('ROLE_MANAGER') || $user->hasRole('ROLE_SUPER_ADMIN')
        ) {
            return $this->redirectToRoute('manager_contract_list');
        } elseif ($user->hasRole('ROLE_STRUCTURE')
            && $user->getOrganization()->getIsActive() === 1
            || $user->hasRole('ROLE_COMPANY')
            && $user->getOrganization()->getIsActive() === 1
        ) {
            return $this->redirectToRoute('dashboard_index');

        } elseif ($user->hasRole('ROLE_STRUCTURE')
            && $user->getOrganization()->getIsActive() === 0
            || $user->hasRole('ROLE_COMPANY')
            && $user->getOrganization()->getIsActive() === 0
        ) {
            return $this->redirectToRoute('waiting_index');

        } else {
            return $this->render('inscription/index.html.twig');
        }
    }
}