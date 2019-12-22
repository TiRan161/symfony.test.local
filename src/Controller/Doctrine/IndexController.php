<?php


namespace App\Controller\Doctrine;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function index()
    {
        return $this->render('index/Doctrine/index.html.twig');
    }

}