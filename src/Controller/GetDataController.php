<?php


namespace App\Controller;


use App\Entity\Branch;
use App\Entity\Manager;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class GetDataController extends AbstractController
{
    public function getData(Request $request, PaginatorInterface $paginator)
    {
        $managers = $this->getManagers();
        $branch = $this->getBranch();
        $pagination = $paginator->paginate(
            $managers,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('index/getData.html.twig', [
            'pagination' => $pagination,
            'managers' => $managers,
            'branches' => $branch,
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
        return $branch;
    }

    public function getBranchManagers(Branch $branch)
    {
        $managers = $this->getDoctrine()->getRepository(Manager::class)->findBy([
            'branch' => $branch,
        ]);
        return $this->render('index/branchManagers.html.twig', [
            'managers' => $managers,
            'branch' => $branch,
        ]);
    }

    public function getPersonalManager(Manager $manager)
    {
        return $this->render('index/personalPage.html.twig', [
            'manager' => $manager,
        ]);
    }

}