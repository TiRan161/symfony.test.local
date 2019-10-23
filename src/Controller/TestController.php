<?php


namespace App\Controller;


use App\Entity\Manager;
use App\Form\TestFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    public function index()
    {
        $form = $this->createForm(TestFormType::class);
        $managers = $this->getDoctrine()->getRepository(Manager::class)->findAll();
        return $this->render('index/index.html.twig', ['managers' => $managers, 'form' => $form->createView()]);
    }

}