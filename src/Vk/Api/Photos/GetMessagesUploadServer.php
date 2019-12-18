<?php


namespace App\Vk\Api\Photos;


use App\Vk\Api\AbstractMethod;

class GetMessagesUploadServer extends AbstractMethod
{

    protected $url = '/method/photos.getMessagesUploadServer';

    private $peerId;



    /**
     * @inheritDoc
     */
    public function getParams()
    {
        return [
          'peer_id' => $this->peerId,
        ];

        // TODO: Implement getParams() method.
    }

    /**
     * @param mixed $peerId
     */
    public function setPeerId($peerId): void
    {
        $this->peerId = $peerId;
    }
}