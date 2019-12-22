<?php


namespace App\Controller\Native;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function index()
    {
        return $this->render('index/Native/index.html.twig');
    }

}