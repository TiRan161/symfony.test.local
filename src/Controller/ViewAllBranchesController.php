<?php


namespace App\Controller;


use App\Service\BranchService;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ViewAllBranchesController extends AbstractController
{
    private $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    public function getData()
    {
        $branches = $this->branchService->getAllBranch();
        return $this->render('index/branches.html.twig', ['branches' => $branches]);
    }

}