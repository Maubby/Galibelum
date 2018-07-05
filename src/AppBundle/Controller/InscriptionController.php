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
     * @return        Response A Response instance
     */
    public function indexAction()
    {
        return $this->render('inscription/index.html.twig');
    }
}
