<?php
/**
 * UserController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category UserController
 * @package  Controller
 * @author   WildCodeSchool <gaetant@wildcodeschool.fr>
 */
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * User controller.
 *
 * @Route("user")
 *
 * @category Controller
 * @package  Controller
 * @author   WildCodeSchool <gaetant@wildcodeschool.fr>
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/",    name="user_index")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render(
            'user/index.html.twig', array(
            'users' => $users,
            )
        );
    }

    /**
     * Finds and displays a user entity.
     *
     * @param User $user The user entity
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function showAction(User $user)
    {
        return $this->render(
            'user/show.html.twig', array(
            'user' => $user,
            )
        );
    }
}
