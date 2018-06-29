<?php
/**
 * LoginController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category LoginController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\
AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Login controller.
 *
 * @Route("login")
 *
 * @category LoginController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class LoginController implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $authorizationChecker;

    /**
     * Constructor method
     *
     * @param RouterInterface               $router               Router
     * @param AuthorizationCheckerInterface $authorizationChecker After login success
     */
    public function __construct(RouterInterface $router,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Redirection after login successfully
     *
     * @param Request        $request Show posted info
     * @param TokenInterface $token   Use Token
     *
     * @return Response A Response instance
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $response = null;

        if ($this->authorizationChecker->isGranted(
            'ROLE_SUPER_ADMIN'
        )
        ) {
            $response = new RedirectResponse(
                $this->router->generate(
                    'admin_index'
                )
            );
        } else if($this->authorizationChecker->isGranted(
            'ROLE_MANAGER'
        )
        ) {
            $response = new RedirectResponse(
                $this->router->generate(
                    'manager_index'
                )
            );
        } else {
            $response = new RedirectResponse(
                $this->router->generate(
                    'dashboard_index'
                )
            );
        }
        return $response;
    }
}
