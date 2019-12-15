<?php


namespace App\Service;


class VkApiService
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function sendMessage()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.vk.com/method/messages.send', [
            "form_params" => [
                'random_id' => '12314522',
                "user_id" => "27727178",
                'message' => 'бобёр',
                "v" => "5.103",
                'access_token' => $this->token
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