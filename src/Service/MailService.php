<?php


namespace App\Service;


use Doctrine\Common\Collections\ArrayCollection;
use Swift_Message;
use Twig\Environment;

class MailService
{
    private $mailer;
    /** @var Environment */
    private $template;

    public function __construct(\Swift_Mailer $mailer, Environment $template)
    {
        $this->mailer = $mailer;
        $this->template = $template;
    }


    /**
     * @param ArrayCollection $mailingList
     * @param string $subject
     * @param string $template
     * @param array $options
     * @return int
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendEmails(ArrayCollection $mailingList, $subject, $template, $options)
    {
        $message = (new Swift_Message($subject))
            ->setFrom('general@mail.ru')
            ->setTo($mailingList->toArray())
            ->setBody(
                $this->template->render($template, $options));
        return $this->mailer->send($message);

    }


}