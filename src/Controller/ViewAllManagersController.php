<?php


namespace App\Controller;


use App\Form\ManagerFormType;
use App\Service\BranchService;
use App\Service\ManagerService;
use App\Service\SupportService;
use App\Service\VkApiService;
use App\Template\ManagerTemplate;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ViewAllManagersController extends AbstractController
{

    private $managerService;
    private $supportService;
    private $branchService;
    private $vkApiService;

    public function __construct(ManagerService $managerService, SupportService $supportService,
                                BranchService $branchService, VkApiService $vkApiService)
    {
        $this->vkApiService = $vkApiService;
        $this->managerService = $managerService;
        $this->supportService = $supportService;
        $this->branchService = $branchService;
    }


    public function getData(Request $request, PaginatorInterface $paginator)
    {
        $this->vkApiService->sendMessage();
        die();
        $listId = $this->managerService->getIds();
        $pagination = $paginator->paginate(
            $listId,
            $request->query->getInt('page', 1),
            5
        );
        $ids = $pagination->getItems();
        $mangers = $this->managerService->getViewAllByIds($ids);
        return $this->render('index/managers.html.twig', [
            'pagination' => $pagination,
            'managers' => $mangers,
        ]);
    }

    public function getManagerByBranch($id)
    {
        $mangers = $this->managerService->getManagersByBranch($id);
        return $this->render('index/managers.html.twig', [
            'managers' => $mangers,
        ]);
    }

    public function getPersonalManager($code)
    {
        $manager = $this->managerService->getPersonalManager($code);
        if (!$manager) {
            throw new NotFoundHttpException();
        }
        return $this->render('index/personalManager.html.twig', [
            'manager' => $manager,
        ]);
    }

    public function updateManager(Request $request, $code)
    {
        $manager = $this->managerService->getPersonalManager($code);
        $template = (new ManagerTemplate())->getManagerTemplate($manager);
        $template['branchList'] = $this->branchService->getAllBranch();
        return $this->formManager($request, $template);


    }

    public function createManager(Request $request)
    {
        $template = (new ManagerTemplate())->getManagerTemplate();
        $form = $this->createForm(ManagerFormType::class);
        $template['branchList'] = $this->branchService->getAllBranch();
        return $this->formManager($request, $template);
    }
// ajax запросы
    private function formManager(Request $request, $template)
    {
        $code = $template['code'];
        $new = false;
        if (!$code) {
            $code = $this->supportService->getUuid();
            $new = true;
        }
        $data = $request->request->all(); //передаём в сервис
        if ($request->getMethod() === 'POST') {
            if (empty($data['code'])) {

            }
            if (empty($data['surname'])) {

            }
            if (empty($data['name'])) {

            }
            if (empty($data['middleName'])) {

            }
            if (empty($data['email'])) {

            }
            if (empty($data['photo'])) {

            }
            if (empty($data['branch'])) {

            }

            $file = $request->files->get('photo');
                //делаем сервис uploadService, инъектим его к managerService
            $data = [
                'code' => $code,
                'surname' => !empty($request->get('surname')),
                'name' => $request->get('name'),
                'middleName' => $request->get('middleName'),
                'email' => $request->get('email'),
                'photo' => $request->get('photo'),
                'branch' => $request->get('branchList'),
            ];

            foreach ($data as $key => $value) {
                if (!$value) {
                    $this->addFlash('warning', $key . ' пустое поле');
                    $this->redirectToRoute('create_manager');
                }
            }

            if ($new) {
                $this->managerService->writeManager($data);
            } else {
                $this->managerService->updateManager($data);
            }

            return $this->redirectToRoute('view_all_managers');
        }
        return $this->render('index/writePersonalManager.html.twig', ['manager' => $template]);
    }

//    private function getPathPhoto($photo)
//    {
//        $path = $this->getParameter('kernel.project_dir') . '/public/uploads/photo/';
//        $publicPath = '/uploads/photo/';
//        $fileName = "{$photo->getFilename()}.{$photo->getClientOriginalExtension()}";
//        $photo->move($path, $fileName);
//        $manager->setPhoto($publicPath . $fileName);
//    }

    public function deleteManager($id)
    {
        $this->managerService->removeManager($id);
        return $this->redirectToRoute('view_all_managers');
    }


}