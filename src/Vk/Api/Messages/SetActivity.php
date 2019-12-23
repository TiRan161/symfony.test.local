<?php


namespace App\Vk\Api\Messages;


use App\Vk\Api\AbstractMethod;

class SetActivity extends AbstractMethod
{
    const TYPE_TYPING = 'typing';
    const TYPE_AUDIO = 'audiomessage';

    const TYPE_LIST = [
        self::TYPE_TYPING,
        self::TYPE_AUDIO
    ];

    protected $url = '/method/messages.setActivity';

    private $userId;
    private $type = self::TYPE_TYPING;
    private $peerId;
    private $groupId;

    /**
     * @inheritDoc
     */
    public function getParams()
    {
        return [
            'user_id' => $this->userId,
            'type' => $this->type
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
     * @param string $type
     */
    public function setType(string $type): void
    {
        if (in_array($type, self::TYPE_LIST, true)) {
            $this->type = $type;
        }
    }

    /**
     * @param mixed $groupId
     */
    public function setGroupId($groupId): void
    {
        $this->groupId = $groupId;
    }

}