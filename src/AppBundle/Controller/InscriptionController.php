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
        return $this->render('inscription/index.html.twig');
    }

}
