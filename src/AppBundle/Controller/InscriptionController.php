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

use User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/",    name="inscription_index")
     * @Method("GET")
     * @return        Response A Response instance
     */
    public function indexAction()
    {
        $user = $this->getUser();

        if ($user->hasRole('ROLE_STRUCTURE')
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
            return $this->redirectToRoute('inscription_index');
        }
    }

}
