<?php


namespace App\Controller;


use App\Entity\Branch;
use App\Entity\Manager;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetDataController extends AbstractController
{
    public function getData()
    {
        $managers = $this->getManagers();
        $branches = $this->getBranch();
        return $this->render('index/getData.html.twig', [
            'managers' => $managers,
            'branches' => $branches,
        ]);
    }


    public function getManagers()
    {
        /** @var EntityRepository $managersRepo */
        $managersRepo = $this->getDoctrine()->getRepository(Manager::class);
        return $managersRepo->matching(Criteria::create()->orderBy(['id' => 'ASC']));
    }

    public function getBranch()
    {
        $branch = $this->getDoctrine()->getRepository(Branch::class)->findAll();
        //
        return $branch;
    }

    public function getBranchManagers(Branch $branch)
    {
        //var_dump($branch);
        //->where(Criteria::expr()->eq('branch',)
        $managers = $this->getDoctrine()->getRepository(Manager::class)->findBy([
            'branch' => $branch,
        ]);
        return $this->render('index/branchManagers.html.twig', [
            'managers' => $managers,
            'branch' => $branch,
        ]);
    }

    public function getPersonalManager (Manager $manager)
    {
        return $this->render('index/personalPage.html.twig',[
            'manager' => $manager,
        ]);
    }

}