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

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Mailer\TwigSwiftMailer;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * EmailConfirmationListener class.
 *
 * @category Listener
 * @package  Listener
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class EmailConfirmationListener implements EventSubscriberInterface
{
    private $_mailer;
    private $_tokenGenerator;
    private $_router;
    private $_session;

    /**
     * EmailConfirmationListener constructor.
     *
     * @param TwigSwiftMailer         $mailer         FOSUser's template mailer
     * @param TokenGeneratorInterface $tokenGenerator Create unique token
     * @param UrlGeneratorInterface   $router         Router to redirect to route
     * @param SessionInterface        $session        Using session for flash
     */
    public function __construct(TwigSwiftMailer $mailer, TokenGeneratorInterface $tokenGenerator, UrlGeneratorInterface $router, SessionInterface $session)
    {
        $this->_mailer =  $mailer;
        $this->_tokenGenerator = $tokenGenerator;
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
            FOSUserEvents::REGISTRATION_SUCCESS => [
                ['onRegistrationSuccess', -10],
            ],
        ];
    }

    /**
     * Send email on registration success
     *
     * @param  FormEvent $event catching event
     * @return void
     */
    public function onRegistrationSuccess(FormEvent $event)
    {
        /**
         * Getting current user
         *
         * @var $user \FOS\UserBundle\Model\UserInterface
         */
        $user = $event->getForm()->getData();

        $user->setEnabled(false);
        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->_tokenGenerator->generateToken());
        }

        $this->_mailer->sendConfirmationEmailMessage($user);

        $this->_session->set('fos_user_send_confirmation_email/email', $user->getEmail());
        $this->_session->getFlashBag()->add(
            'emailconfirmed',
            'Un email de validation a été envoyé à l\'adresse renseignée.
             Si celui-ci n\'a pas été reçu, vérifiez vos spams ou contactez Galibelum.'
        );
        $url = $this->_router->generate('fos_user_security_login');
        $event->setResponse(new RedirectResponse($url));
    }
}
