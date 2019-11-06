<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexPageController extends AbstractController
{
    public function index()
    {
        return $this->render('index/index.html.twig');
    }

    public function getUuid()
    {
        if (function_exists('com_create_guid') === true)
        {
            $uuid=trim(com_create_guid(), '{}');
            $result =$uuid;
        }
        else
        {
            $data = openssl_random_pseudo_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
            $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
            $result = $uuid;
        }

        return $result;
    }

}