<?php


namespace App\Controller;


use App\Form\MessagesFormType;
use App\Service\VkApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends AbstractController
{

    private $vkApiService;

    public function __construct(VkApiService $vkApiService)
    {
        $this->vkApiService = $vkApiService;
    }

    public function send (Request $request) {

        $form = $this->createForm(MessagesFormType::class);
        $form->handleRequest($request);
        if ($request->getMethod()==='POST') {
            $message = $request->files->get('image');
            $this->vkApiService->sendMessage($message);

        }
        return $this->render('VkApi/sendMessages.html.twig', ['message' => $form->createView()]);
    }

}