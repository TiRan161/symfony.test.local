<?php


namespace App\Vk\Api\Messages;


class Send
{
    protected $url = '/method/messages.send';

    private $userId;
    private $randomId;
    private $peerId;
    private $domain;
    private $chatId;
    private $userIds;
    private $message;
    private $lat;
    private $long;
    private $attachment;
    private $replyTo;
    private $forwardMessages;
    private $stickerId;
    private $groupId;
    private $keyboard;
    private $payload;
    private $dontParseLinks;
    private $disableMentions;
    private $intent;

    /**
     * @inheritDoc
     */
    public function getParams()
    {
        return [
            'random_id' => (new \DateTime())->getTimestamp(),
            "user_id" => $this->userId,
            'message' => $this->message
        ];
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

}