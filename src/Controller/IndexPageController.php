<?php


namespace App\Controller;


use App\Service\UuidService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexPageController extends AbstractController
{
    private $uuid;

    public function __construct(UuidService $uuid)
    {
        $this->uuid = $uuid;
        return $uuid;
    }

    public function index()
    {
        echo $this->uuid->getUuid();


        return $this->render('index/index.html.twig');
    }

}