<?php


namespace App\Controller;


use App\Entity\Branch;
use App\Entity\Manager;
use App\Form\BranchFormType;
use App\Form\ManagerFormType;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ManagerBaseController extends AbstractController
{
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

    public function formatManager($request, Manager $manager)
    {
        $form = $this->createForm(ManagerFormType::class, $manager);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($manager);
            $em->flush();
            return $this->redirectToRoute('get_data');
        }
        return $this->render('index/writeManager.html.twig', ['manager' => $form->createView()]);
    }

    public function editManager(Request $request, Manager $manager)
    {
        return $this->formatManager($request, $manager);

    }


    public function writeManager(Request $request)
    {
        $manager = new Manager();
        //$manager = $this->formatManager($request, $manager);
        return $this->sendEmails($manager );

    }

    public function deleteBranch(Branch $branch)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($branch);
            $em->flush();
            return $this->redirectToRoute('get_data');

    }

    public function deleteManager(Manager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($manager);
        $em->flush();
        return $this->redirectToRoute('get_data');
    }

    public function sendEmails(Manager $newManager)
    {
        $mailer = \Swift_Mailer::class;
        /** @var EntityRepository $managers */
        $managers = $this->getDoctrine()->getRepository(Manager::class);
        $managers = $managers->matching(Criteria::create()->orderBy(['branch.name' => $newManager->getBranch()])); //////////?????????????/
        foreach ($managers as $manager) {
            if (!null == $manager->getEmail()) {
                $message = (new \Swift_Message('Welcome email'))
                    ->setFrom('general@mail.ru')
                    ->setTo($manager->getEmail())
                    ->setBody(
                        $this->renderView(
                            ':Email:welcome.txt.twig',
                            ['newManager' => $newManager]));

                $mailer->send($message);
            }
        }


    }

    //$this->addFlash(type,text)
    // при добавлении менеджера уведомить весь отдел
    //asasdas

}