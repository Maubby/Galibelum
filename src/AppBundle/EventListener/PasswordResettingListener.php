<?php

/**
 * Event Listener file
 *
 * PHP version 7.2
 *
 * @category Listener
 * @package  Listener
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * PasswordResettingListener class.
 *
 * @category Listener
 * @package  Listener
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class PasswordResettingListener implements EventSubscriberInterface
{
    private $_router;
    private $_session;

    /**
     * PasswordResettingListener constructor.
     *
     * @param UrlGeneratorInterface $router  Router to redirect to route
     * @param SessionInterface      $session Using session for flash
     */
    public function __construct(UrlGeneratorInterface $router,
        SessionInterface $session
    ) {
        $this->_router = $router;
        $this->_session = $session;
    }

    /**
     * Check password resetting success event from FOSUser
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::RESETTING_RESET_SUCCESS => [
                ['onPasswordResettingSuccess', -10],
            ],
        ];
    }

    /**
     * Redirect to profile route with a flashbag
     *
     * @param FormEvent $event catching event
     *
     * @return void
     */
    public function onPasswordResettingSuccess(FormEvent $event)
    {
        /**
         * Getting current user
         *
         * @var $user \FOS\UserBundle\Model\UserInterface
         */
        $user = $event->getForm()->getData();

        $user->setConfirmationToken(null);
        $user->setPasswordRequestedAt(null);
        $user->setEnabled(true);

        $this->_session->getFlashBag()->add(
            'resettingsuccess',
            'Votre mot de passe a bien été réinitialisé.'
        );

        $url = $this->_router->generate('fos_user_profile_edit');
        $event->setResponse(new RedirectResponse($url));
    }
}
