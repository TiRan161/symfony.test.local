<?php


namespace App\Service;


use App\Vk\Api\AbstractMethod;
use App\Vk\Api\SendMessage;
use App\Vk\Api\SetAction;
use App\VK_Api\Messages;

class VkApiService
{
    private $token;
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

    public function sendMessage()
    {
        $sendClass = new SetAction();
        $sendClass->setUserId();
//        $sendClass->setMessage('Привет');
        $sendClass->setUserId('27727178');

        $result = $this->executorApiMethods($sendClass);


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

}