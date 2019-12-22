<?php


namespace App\Vk\Api\Photos;


use App\Vk\Api\AbstractMethod;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SendFileToServer
{
    private $url;
    /** @var array */
    private $photo;
    private $method = 'POST';


    public function getRequest()
    {
        $client = new Client();
        if ($this->method === 'POST') {
            $options = $this->photo;
        } else {
            throw new HttpException('Method not exist');
        }

        return $client->request($this->method, $this->url, $options);


    }
    public function getResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() !== 200) {
            throw new HttpException($response->getStatusCode());
        }
        $body = $response->getBody();
        $data = json_decode($body);

        if (!empty($data->error)) {
            throw new \LogicException($data->error->error_msg, $data->error->error_code);
        }
        return $response;
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