<?php


namespace App\Service;


use App\VK_Api\Messages;

class VkApiService
{
    private $token;
    private $version = '5.103';

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function sendMessage()
    {
        $params = (new Messages($this->token, $this->version))->sendMessage();
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.vk.com/method/messages.send', $params);
        $data = json_decode($response->getBody());
        $data1 = $response;
        var_dump($data);
        echo '<br>';
        var_dump($data1);

//        $response = $client->request('POST', 'https://api.vk.com/method/groups.getMembers', [
//
//        ]);


    }

}