<?php


namespace App\Controller;


use App\Form\ManagerFormType;
use App\Service\ManagerService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ViewAllManagersController extends AbstractController
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
        return $this->render('index/managers.html.twig',[
            'pagination' => $pagination,
            'managers' => $mangers,
        ]);
    }

    public function getManagerByBranch ($id)
    {
        $mangers = $this->managerService->getManagersByBranch($id);
        return $this->render('index/managers.html.twig',[
            'managers' => $mangers,
        ]);
    }

    public function getPersonalManager ($code)
    {
        $manger = $this->managerService->getPersonalManager($code);
        return $this->render('index/personalManager.html.twig',[
            'manager' => $manger,
        ]);
    }

    public function createManager(Request $request)
    {
        return $this->formManager($request);
    }

    private function formManager(Request $request)
    {
        $form = $this->createForm(ManagerFormType::class);
        $form->handleRequest($request);
    }

    public function deleteManager($id)
    {
        $this->managerService->removeManager($id);
        return $this->redirectToRoute('view_all_managers');
    }



}