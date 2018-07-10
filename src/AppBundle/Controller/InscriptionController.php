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
        if ($this->getUser()->hasRole('ROLE_STRUCTURE')
            || $this->getUser()->hasRole('ROLE_COMPANY')
        ) {
            if ($this->getUser()->getOrganization->getIsActive() === 0
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
            return $this->render('inscription/index.html.twig');
        }
    }
}