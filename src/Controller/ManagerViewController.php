<?php


namespace App\Controller;


use App\Entity\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ManagerFormType;

class ManagerViewController extends AbstractController
{
    private function formatManager(Request $request, Manager $manager)
    {
        $form = $this->createForm(ManagerFormType::class, $manager);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $form->getData();
        }
    }

}