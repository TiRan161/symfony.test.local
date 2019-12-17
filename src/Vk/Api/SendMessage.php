<?php


namespace App\Vk\Api;


class SendMessage extends AbstractMethod
{
    protected $url = '/method/messages.send';

    private $userId;
    private $message;

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