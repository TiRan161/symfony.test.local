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
        $params = (new Messages())->sendMessage();
        //var_dump($params);
        $inipath = php_ini_loaded_file ();
        echo ('inipath - '. $inipath);
        die;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.vk.com/method/messages.send', [
            "form_params" => [
                'random_id' => '12314522',
                "user_id" => "27727178",
                'message' => 'бобёр',
                "v" => "5.103",
                'access_token' => '8c49b8151dc2257c983866a08e59782e416fa0cc0f9b5efe21b65933746baea6dece0945eb629d5260b9c'
            ]]);
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