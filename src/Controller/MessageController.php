<?php


namespace App\Controller;


use App\Form\MessagesFormType;
use App\Service\VkApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
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
//        $data = $request->request->all();
//        $this->vkApiService->setActivity();
        if ($request->getMethod() === 'POST') {
//            $message = $data['message'];
//            /** @var UploadedFile $messages */
//            $messages = $request->files->get('image');
//            $message['multipart'] = [
//                'name' => $messages->getFilename(),
//                'content' => fopen($messages->getPathname().'.'.$messages->getClientOriginalExtension(),'r'),
//                ];
//        if ($request->getMethod() === 'POST') {
//            /** @var UploadedFile $messages */
//            $messages = $request->files->get('image');
//            $message['multipart'] = [
//                [
//                    'name' => $messages->getFilename(),
//                    'content' => fopen('/tmp', 'r'),
//                    'filename' => 'phplt8xZJ.jpg',
//                ]
//            ];
//            $message['headers'] = ['access_token' => '8c49b8151dc2257c983866a08e59782e416fa0cc0f9b5efe21b65933746baea6dece0945eb629d5260b9c'];
//            $this->vkApiService->sendMessage($message);
//            $this->vkApiService->getGroupMembers('189861095');

        }
        $file['multipart'] = [
                [
                    'name' => 'photo',
                    'contents' => fopen('/var/php/www/symfony.test.local/public/uploads/photo/php1yNy8W.jpg', 'r'),
                    'filename' => 'php1yNy8W.jpg'
                ]
            ];
        $file['headers'] = ['access_token' => '8c49b8151dc2257c983866a08e59782e416fa0cc0f9b5efe21b65933746baea6dece0945eb629d5260b9c'];
        $this->vkApiService->sendMessage($file);
        return $this->render('VkApi/sendMessages.html.twig', ['message' => $form->createView()]);
    }

    public function setActivity()
    {
        $this->vkApiService->setActivity();
        return new JsonResponse(['success' => true, "message" => 'Норм парни']);
    }

}