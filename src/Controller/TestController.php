<?php


namespace App\Controller;


use App\Entity\Manager;
use App\Form\TestFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestController extends AbstractController
{
    public function index()
    {
        return $this->render('index/index.html.twig');
    }

}