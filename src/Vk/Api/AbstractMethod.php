<?php


namespace App\Vk\Api;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractMethod
{

    private $host = 'https://api.vk.com';

    protected $method = 'POST';
    protected $url = '';

    private $version;

    private $accessToken;

    /**
     * @return array
     */
    public abstract function getParams();

    public function getResult()
    {
        $request = $this->getRequest();

        return $this->getResponse($request);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getRequest()
    {
        $client = new Client();
        $params = $this->getParams();
        $params['v'] = $this->version;
        $params['access_token'] = $this->accessToken;
        if ($this->method === 'POST') {
            $options = [
                'form_params' => $params
            ];
        } elseif ($this->method === 'GET') {
            $options = [
                'query' => $params
            ];
        } else {
            throw new HttpException('Method not exist');
        }

        return $client->request($this->method, $this->host . $this->url, $options);


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
     * @param mixed $version
     */
    public function setVersion($version): void
    {
        $this->version = $version;
    }

    /**
     * @param mixed $accessToken
     */
    public function setAccessToken($accessToken): void
    {
        $this->accessToken = $accessToken;
    }


}