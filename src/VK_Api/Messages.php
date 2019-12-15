<?php


namespace App\VK_Api;


class Messages
{
    private $token;


    public function sendMessage() {

        $data = [];

        $data['method'] = '/messages.send';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.vk.com/method/messages.send', [
            "form_params" => [
                'random_id' => '12314522',
                "user_id" => "27727178",
                'message' => 'бобёр',
                "v" => "5.103",
                'access_token' => $this->token
            ]]);
    }

}