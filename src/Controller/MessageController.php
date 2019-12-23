<?php


namespace App\Controller;


use App\Form\MessagesFormType;
use App\Service\VkApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends AbstractController
{

    private $vkApiService;

    public function __construct(VkApiService $vkApiService)
    {
        $this->vkApiService = $vkApiService;
    }

    public function send(Request $request)
    {

        $form = $this->createForm(MessagesFormType::class);
        $form->handleRequest($request);
        $data = $request->request->all();
        $this->vkApiService->setActivity();
        if ($request->getMethod() === 'POST') {
            $message = $data['message'];
//            /** @var UploadedFile $messages */
//            $messages = $request->files->get('image');
//            $message['multipart'] = [
//                'name' => $messages->getFilename(),
//                'content' => fopen($messages->getPathname().'.'.$messages->getClientOriginalExtension(),'r'),
//                ];
            $this->vkApiService->sendMessage($message);
//            $this->vkApiService->getGroupMembers('189861095');

        }
        return $this->render('VkApi/sendMessages.html.twig', ['message' => $form->createView()]);
    }

}