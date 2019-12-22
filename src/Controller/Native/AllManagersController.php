<?php


namespace App\Controller\Native;


use App\Service\ManagerService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AllManagersController extends AbstractController
{
    private $managerService;

    public function __construct(ManagerService $managerService)
    {
        $this->managerService = $managerService;
    }

    public function getData(Request $request, PaginatorInterface $paginator)
    {
        $listId = $this->managerService->getIds();
        $pagination = $paginator->paginate(
            $listId,
            $request->query->getInt('page', 1),
            5
        );
        $ids = $pagination->getItems();
        $mangers = $this->managerService->getViewAllByIds($ids);
        return $this->render('index/Native/allManagers.html.twig', [
            'pagination' => $pagination,
            'managers' => $mangers,
        ]);
    }

}