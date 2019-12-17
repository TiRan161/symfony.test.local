<?php


namespace App\VK_Api;


class Messages
{
    private $token = '8c49b8151dc2257c983866a08e59782e416fa0cc0f9b5efe21b65933746baea6dece0945eb629d5260b9c';
    private $version = '5.103';

    public function __construct()
    {
//        $this->token = $token;
//        $this->version = $version;
    }


    public function sendMessage(?array $params = null)
    {

        $params['form_params'] = [
            'user_id' => $params['user_id'] ?? '',
            'random_id' => $params['random_id'] ?? '',
            'peer_id' => $params['peer_id'] ?? '',
            'domain' => $params['domain'] ?? '',
            'chat_id' => $params['chat_id'] ?? '',
            'user_ids' => $params['user_ids'] ?? '',
            'message' => $params['message'] ?? '',
            'lat' => $params['lat'] ?? '',
            'long' => $params['long'] ?? '',
            'attachment' => $params['attachment'] ?? '',
            'reply_to' => $params['reply_to'] ?? '',
            'forward_messages' => $params['forward_messages'] ?? '',
            'sticker_id' => $params['sticker_id'] ?? '',
            'group_id' => $params['group_id'] ?? '',
            'keyboard' => $params['keyboard'] ?? '',
            'payload' => $params['payload'] ?? '',
            'dont_parse_links' => $params['dont_parse_links'] ?? '',
            'disable_mentions' => $params['disable_mentions'] ?? '',
            'intent' => $params['intent'] ?? '',
            'v' => $this->version,
            'access_token' => $this->token,

        ];
        //$client = new \GuzzleHttp\Client();
        //$response = $client->request('POST', 'https://api.vk.com/method/messages.send', $params);
        return $params;

        $data['method'] = '/messages.send';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.vk.com/method/messages.send', [
            "form_params" => $params
        ]);


    }


}