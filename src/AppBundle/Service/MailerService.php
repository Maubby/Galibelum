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
     * @param string $fromEmail Sender's email
     * @param string $toEmail   Receiver's email
     * @param string $subject   Email's subject
     * @param string $message   Email's body
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return int The number of successful recipients.
     * Can be 0 which indicates failure
     */
    public function sendEmail($fromEmail, $toEmail, $subject, $message)
    {
        //If your service is another, then read the following article
        //to know which smpt code to use and which port
        //http:ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setCharset('UTF-8')
            ->setTo($toEmail)
            ->setBody(
                $this->templating->render(
                    'email/notification.html.twig',
                    array(
                        'message' => $message,
                        'subject' => $subject
                    )
                ),
                'text/html'
            );
        return $this->mailerUser->send($message);
    }
}