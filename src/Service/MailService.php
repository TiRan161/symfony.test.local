<?php


namespace App\Service;


use Doctrine\Common\Collections\ArrayCollection;
use Swift_Message;
use Twig\Environment;

class MailService
{
    private $mailer;
    private $template;

    public function __construct(\Swift_Mailer $mailer,  \Twig\Environment $template)
    {
        $this->mailer = $mailer;
        $this->template = $template;
    }


    public function sendEmails($from, $manager)
    {
        /** @var $from ArrayCollection */
        $message = (new Swift_Message('Welcome email'))
            ->setFrom('general@mail.ru')
            ->setTo($from->toArray())
            ->setBody(
                $this->template->render(
                    'Email/welcome.txt.twig',
                    ['newManager' => $manager]));
        return $this->mailer->send($message);

    }


}