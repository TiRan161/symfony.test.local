<?php


namespace App\Vk\Api;


class SetAction extends AbstractMethod
{
    protected $url = '/method/messages.setActivity';

    private $userId;

    /**
     * @inheritDoc
     */
    public function getParams()
    {
        return [
            'user_id' => $this->userId,
            'type' => 'typing'
        ];
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }


}