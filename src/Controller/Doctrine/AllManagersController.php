<?php


namespace App\Controller\Doctrine;


use App\Entity\Branch;
use App\Entity\Manager;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AllManagersController extends AbstractController
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
//        $managersIdOnPage = $pagination->getItems();
//        $managersWithId = $this->getManagersWithId($managersIdOnPage);
        return $this->render('index/Doctrine/allManagers.html.twig', [
            'pagination' => $pagination, //пагинатор не работает
//            'managers' => $managersWithId,
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
        return $this->getDoctrine()->getRepository(Branch::class)->findAll();
    }

}