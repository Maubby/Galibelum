<?php
/**
 * Mailer service file
 *
 * PHP version 7.2
 *
 * @category Service
 * @package  Service
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Service;

/**
 * Mailer class service.
 *
 * @category Service
 * @package  Service
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class MailerService
{
    protected $mailerUser;
    protected $templating;
    /**
     * Send an email
     *
     * @param \Swift_Mailer     $mailerUser SwiftMailer
     * @param \Twig_Environment $templating Use template twig
     */
    public function __construct(
        \Swift_Mailer $mailerUser, \Twig_Environment $templating
    ) {
        $this->mailerUser     = $mailerUser;
        $this->templating = $templating;
    }

    /**
     * Send an email with recipients
     *
     * @param string $fromEmail    Sender's email
     * @param string $toEmail      Receiver's email
     * @param string $subject      Email's subject
     * @param string $message      Email's body
     * @param null   $managerTel   Variable manager phone number
     * @param null   $managerEmail Variable manager email address
     *
     * @return int The number of successful recipients.
     * Can be 0 which indicates failure
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendEmail($fromEmail, $toEmail,
        $subject, $message, $managerTel = null,
        $managerEmail = null
    ) {
        $message = \Swift_Message::newInstance()
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setCharset('UTF-8')
            ->setSubject($subject)
            ->setBody(
                $this->templating->render(
                    'email/notification.html.twig',
                    array(
                        'subject' => $subject,
                        'message' => $message,
                        'managerTel' => $managerTel,
                        'managerEmail' => $managerEmail,
                        'url' => 'https://www.galibelum.fr/login'
                    )
                ),
                'text/html'
            );
        return $this->mailerUser->send($message);
    }
}