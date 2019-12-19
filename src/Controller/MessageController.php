<?php


namespace App\Controller;


use App\Form\MessagesFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends AbstractController
{

    public function send (Request $request) {

        $form = $this->createForm(MessagesFormType::class);
        $form->handleRequest($request);
        if ($request->getMethod()==='POST') {
            $message = $request->files->get('image');
            var_dump($message);

        }
        return $this->render('VkApi/sendMessages.html.twig', ['message' => $form->createView()]);
    }

}