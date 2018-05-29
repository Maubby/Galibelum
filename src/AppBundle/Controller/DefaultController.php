<?php
/**
 * DefaultController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category DefaultController
 * @package  Controller
 * @author   WildCodeSchool <gaetan@wildcodeschool.fr>
 */
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default controller.
 *
 * @category Controller
 * @package  Controller
 * @author   WildCodeSchool <gaetan@wildcodeschool.fr>
 */
class DefaultController extends Controller
{
    /**
     * Lists all entities.
     *
     * @Route("/", name="homepage")
     * @return     Response A Response instance
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render(
            'default/index.html.twig',
            [
                'base_dir' => realpath(
                    $this->getParameter('kernel.project_dir')
                ).DIRECTORY_SEPARATOR,
                ]
        );
    }
}
