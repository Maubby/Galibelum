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
class Mailer
{
    protected $mailer;
    protected $templating;
    /**
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $templating
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer     = $mailer;
        $this->templating = $templating;
    }

    /**
     * Send an email with recipients
     *
     * @param string $fromEmail Sender's email
     * @param string $toEmail Receiver's email
     * @param string $recipientName Receiver's name
     * @param string $subject Email's subject
     * @param string $message Email's body
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendEmail($fromEmail, $toEmail, $recipientName, $subject, $message)
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
                    'email/contact.html.twig',
                    array('name' => $recipientName,
                        'subject' => $subject,
                        'message' => $message
                    )
                ),
                'text/html'
            );
        return $this->mailer->send($message);
    }
}