<?php

/**
 * Event Listener file
 *
 * PHP version 7.1
 *
 * @category Listener
 * @package  Listener
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\EventListener;

use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * RegistrationConfirmedListener class.
 *
 * @category Listener
 * @package  Listener
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class RegistrationConfirmedListener implements EventSubscriberInterface
{
    private $_router;
    private $_session;

    /**
     * EmailConfirmationListener constructor.
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
     * Check registration success event from FOSUser
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_CONFIRM => [
                ['onRegistrationConfirm', -10],
            ],
        ];
    }

    /**
     * Redirect on inscription index after registration
     *
     * @param GetResponseUserEvent $event catching event
     *
     * @return void
     */
    public function onRegistrationConfirm(GetResponseUserEvent $event)
    {
        $this->_session->getFlashBag()->add(
            'registrationconfirmed',
            'Votre compte est validé. Vous pouvez désormais créer votre structure 
            eSport ou sponsoriser des offres sur Galibelum.'
        );
        $url = $this->_router->generate('inscription_index');
        $event->setResponse(new RedirectResponse($url));
    }
}
