<?php


namespace App\Vk\Api\Photos;


use App\Vk\Api\AbstractMethod;

class SendFileToServer extends AbstractMethod
{
    protected $url;
    protected $host ='';

    private $photo;


    /**
     * @inheritDoc
     */
    public function getParams()
    {
        return [
            'photo' => $this->photo,
        ];
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo): void
    {
        $this->photo = $photo;
    }
}