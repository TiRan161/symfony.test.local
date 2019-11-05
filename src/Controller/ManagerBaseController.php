<?php


namespace App\Controller;


use App\Entity\Branch;
use App\Entity\Manager;
use App\Form\BranchFormType;
use App\Form\ManagerFormType;
use App\Service\MailService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Tests\Compiler\C;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class ManagerBaseController extends AbstractController
{
    /** @var MailService  */
    private $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function formatBranch($request, Branch $branch)
    {
        $form = $this->createForm(BranchFormType::class, $branch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $branch = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($branch);
            $em->flush();
            return $this->redirectToRoute('get_data');
        }
        return $this->render('index/writeBranch.html.twig', ['branch' => $form->createView()]);

    }

    public function writeBranch(Request $request)
    {
        return $this->formatBranch($request, new Branch());
    }

    public function editBranch(Request $request, Branch $branch)
    {
        return $this->formatBranch($request, $branch);
    }

//    public function formatManager($request, Manager $manager)
//    {
//        $form = $this->createForm(ManagerFormType::class, $manager);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $manager = $form->getData();
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($manager);
//            $em->flush();
//            return $this->redirectToRoute('get_data');
//        }
//        return $this->render('index/writeManager.html.twig', ['manager' => $form->createView()]);
//    }
    /**
     * @param Request $request
     * @param Manager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function editManager(Request $request, Manager $manager)
    {
        $form = $this->createForm(ManagerFormType::class, $manager);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->sendEmails($manager);
            return $this->redirectToRoute('get_data');
        }
        return $this->render('index/writeManager.html.twig', ['manager' => $form->createView()]);

    }


    public function writeManager(Request $request, \Swift_Mailer $mailer)
    {
        $manager = new Manager();
        $form = $this->createForm(ManagerFormType::class, $manager);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form['photo']->getData();
            $projectDir = $this->getParameter('kernel.project_dir');
            $path = $projectDir . '/public/uploads/photo/';
            $publucPath = '/uploads/photo/';
            $fileName = "{$photoFile->getFilename()}.{$photoFile->getClientOriginalExtension()}";
            $photoFile->move($path, $fileName);
            $manager->setPhoto($publucPath.$fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($manager);
            $em->flush();
            $this->sendEmails($manager);
            return $this->redirectToRoute('get_data');
        }
        return $this->render('index/writeManager.html.twig', ['manager' => $form->createView()]);


    }

    public function deleteBranch(Branch $branch)
    {
        $manager = $this->getDoctrine()->getRepository(Manager::class);
        /** @var ArrayCollection $manager */
        $manager = $manager->matching(new Criteria(Criteria::expr()->eq('branch', $branch)));
        if (!$manager->isEmpty()) {
            $this->addFlash('warning', 'Нельзя удалить отдел в котором находятся менеджеры');

        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($branch);
            $em->flush();
        }

        return $this->redirectToRoute('get_data');

    }

    public function deleteManager(Manager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($manager);
        $em->flush();
        return $this->redirectToRoute('get_data');
    }

    /**
     * @param Manager $newManager
     * @return int
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendEmails(Manager $newManager)
    {
        //service в папке src для mailerservice
        /** @var EntityRepository $managers */
        $managers = $this->getDoctrine()->getRepository(Manager::class);
        /** @var ArrayCollection $managers */
        $managers = $managers->matching(new Criteria(Criteria::expr()->andX(
            Criteria::expr()->eq('branch', $newManager->getBranch()),
            Criteria::expr()->neq('id', $newManager->getId()),
            Criteria::expr()->neq('email', null)
        )));

        $emailsArray = $managers->map(
            static function (Manager $manager) {
                return $manager->getEmail();
            }
        );
        return $this->mailService->sendEmails(
            $emailsArray,
            'Новый сотрудник',
            'Email/welcome.txt.twig',
            ['newManager' => $newManager]);
    }

    //$this->addFlash(type,text)
    // при добавлении менеджера уведомить весь отдел
    //asasdas

}