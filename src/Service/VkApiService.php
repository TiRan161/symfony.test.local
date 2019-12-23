<?php


namespace App\Service;


use App\Vk\Api\AbstractMethod;
use App\Vk\Api\Groups\GetMembers;
use App\Vk\Api\Messages\Send;
use App\Vk\Api\Messages\SetActivity;
use App\Vk\Api\Photos\GetMessagesUploadServer;
use App\Vk\Api\Photos\SaveMessagesPhoto;
use App\Vk\Api\Photos\SendFileToServer;
use App\Vk\Api\SendMessage;
use App\Vk\Api\SetAction;

class VkApiService
{
    private $token;
    private $groupId = '189861095';
    private $version = '5.103';

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function executorApiMethods(AbstractMethod $method)
    {
        $method->setAccessToken($this->token);
        $method->setVersion($this->version);
        return $method->getResult();
    }

    public function sendMessage($file)
    {
//        $sendMessage = new Send();
//        $sendMessage->setUserIds($this->getGroupMembers($this->groupId));
//        $sendMessage->setMessage($message);
        //$result = $this->executorApiMethods($sendMessage);
        //return json_decode($result->getBody());




        $upload = new GetMessagesUploadServer();
        $upload->setPeerId('215007720');
        $result = $this->executorApiMethods($upload);
        $uploadBody = json_decode($result->getBody());
        $url = $uploadBody->response->upload_url;
//
        $sendFile = new SendFileToServer();
        $sendFile->setUrl($url);
        $sendFile->setPhoto($file);
        $result = $sendFile->getResponse($sendFile->getRequest());
        //$result = $this->executorApiMethods($sendFile);
        $data = json_decode($result->getBody());
        $photo = $data->photo;
        $hash = $data->hash;
        $server = $data->server;

        $saveMess = new SaveMessagesPhoto();
        $saveMess->setPhoto($photo);
        $saveMess->setHash($hash);
        $saveMess->setServer($server);
        $result = $this->executorApiMethods($saveMess);
        $data = json_decode($result->getBody());
        var_dump($data);

        $photo = 'photo' . $data->response[0]->owner_id . '_' . $data->response[0]->id;
        $sendMessage = new Send();
        $sendMessage->setUserId('215007720');
        $sendMessage->setMessage('asdasd');
        $sendMessage->setAttachment($photo);
        $result = $this->executorApiMethods($sendMessage);

//
//
//        die();
//
//        $typingClass = new SetActivity();
//
//        $sendClass = new SetActivity();
//        //$sendClass->setMessage('Привет');
//        $sendClass->setUserId('27727178');
//        $sendClass->setType(SetActivity::TYPE_AUDIO);
////        $sendClass->setGroupId('189861095');
//        //var_dump($sendClass->getResponse($sendClass->getRequest()));
//
//        $result = $this->executorApiMethods($sendClass);

        //var_dump((json_decode($result->getBody())));


//        $params = (new Messages())->sendMessage();
//        //var_dump($params);
//        $client = new \GuzzleHttp\Client();
//        $response = $client->request('POST', 'https://api.vk.com/method/messages.send', [
//            "form_params" => [
//                'random_id' => (new \DateTime())->getTimestamp(),
//                "user_id" => "27727178",
//                'message' => 'хоба',
//                "v" => "5.103",
//                'access_token' => '8c49b8151dc2257c983866a08e59782e416fa0cc0f9b5efe21b65933746baea6dece0945eb629d5260b9c'
//            ]]);
//        $data = json_decode($response->getBody());
//        var_dump($response);
//        var_dump($data); die;
//        var_dump($data->error->error_code); die;
//        $response = $client->request('POST', 'https://api.vk.com/method/groups.getMembers', [
//
//        ]);


    }

    public function getGroupMembers ($groupId)
    {
        $getMembers = new GetMembers();
        $getMembers->setGroupId($groupId);
        $result = $this->executorApiMethods($getMembers);
        $data = json_decode($result->getBody());
        return $data->response->items;
    }

    public function setActivity ()
    {
        // foreach getmembers для каждого члена группы

        $typingClass = new SetActivity();
        $typingClass->setUserId('215007720');
        $typingClass->setType(SetActivity::TYPE_TYPING);
//        $typingClass->setGroupId('189861095');
//        //var_dump($sendClass->getResponse($sendClass->getRequest()));
//
        $result = $this->executorApiMethods($typingClass);

    }

}