<?php


namespace App\Vk\Api\Photos;


use App\Vk\Api\AbstractMethod;

class SaveMessagesPhoto extends AbstractMethod
{
    protected $url = '/method/photos.saveMessagesPhoto';

    private $photo;
    private $server;
    private $hash;

    /**
     * @inheritDoc
     */
    public function getParams()
    {
        return [
            'photo' => $this->photo,
            'server' => $this->server,
            'hash' => $this->hash,
        ];
        // TODO: Implement getParams() method.
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @param mixed $server
     */
    public function setServer($server): void
    {
        $this->server = $server;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash): void
    {
        $this->hash = $hash;
    }

}