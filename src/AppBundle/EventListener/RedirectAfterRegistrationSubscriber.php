<?php
/**
 * RedirectAfterRegistrationSubscriber File Doc Comment.
 *
 * PHP version 7.1
 *
 * @category RedirectAfterRegistrationSubscriber
 * @package  EventListener
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

/**
 * RedirectAfterRegistrationSubscriber.
 *
 * @category RedirectAfterRegistrationSubscriber
 * @package  EventListener
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class RedirectAfterRegistrationSubscriber implements EventSubscriberInterface
{
    private $_router;

    /**
     * Construct.
     *
     * @param RouterInterface $_router Creation router for a redirection
     */
    public function __construct(RouterInterface $_router)
    {
        $this->_router = $_router;
    }

    /**
     * Redirection to the homepage.
     *
     * @param FormEvent $event Event calling on registration
     *
     * @return void
     */
    public function onRegistrationSuccess(FormEvent $event)
    {
        $url = $this->_router->generate('homepage');
        $reponse = new RedirectResponse($url);
        $event->setResponse($reponse);
    }

    /**
     * GetSubscribeEvents.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess'
        ];
    }
}