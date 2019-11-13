<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexPageController extends AbstractController
{

    public function index()
    {
        return $this->render('index/index.html.twig');
    }

    public function newIndex()
    {
        return $this->render('index/newIndex.html.twig');
    }

}