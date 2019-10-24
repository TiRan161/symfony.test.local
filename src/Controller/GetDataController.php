<?php


namespace App\Controller;


use App\Entity\Branch;
use App\Entity\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetDataController extends AbstractController
{
    public function getData()
    {
        $managers = $this->getManagers();
        $branches = $this->getBranch();
        return $this->render('index/getData.html.twig',[
            'managers' => $managers,
            'branches' => $branches,
            ]);
    }


    public function getManagers()
    {
        $managers = $this->getDoctrine()->getRepository(Manager::class)->findAll();
        return $managers;
    }

    public function getBranch()
    {
        $branch = $this->getDoctrine()->getRepository(Branch::class)->findAll();
        return $branch;
    }

}