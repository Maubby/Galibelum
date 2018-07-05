<?php
/**
 * DefaultController File Doc Comment
 *
 * PHP version 7.1
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
 * @category DefaultController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
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
