<?php


namespace App\Vk\Api\Messages;


use App\Vk\Api\AbstractMethod;

class Send extends AbstractMethod
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
        $params = [
            'random_id' => (new \DateTime())->getTimestamp(),
        ];
        if (null !== $this->userId) {
            $params['user_id'] = $this->userId;
        }
        if (null !== $this->userIds) {
            $params['user_ids'] = $this->userIds;
        }
        if (null !== $this->message) {
            $params['message'] = $this->message;
        }
        return $params;
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

    /**
     * @param mixed $userIds
     */
    public function setUserIds($userIds): void
    {
        $listId = '';
        foreach ($userIds as $key => $value) {
            $listId .= $value . ',';
        }
        $this->userIds = $listId;
    }

}