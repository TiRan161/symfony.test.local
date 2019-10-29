<?php


namespace App\Controller;


use App\Entity\Branch;
use App\Entity\Manager;
use App\Form\BranchFormType;
use App\Form\ManagerFormType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Swift_Mailer;
use Swift_Message;
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
        $form = $this->createForm(ManagerFormType::class, $manager);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($manager);
            $em->flush();
            $this->sendEmails($manager );
            return $this->redirectToRoute('get_data');
        }
        return $this->render('index/writeManager.html.twig', ['manager' => $form->createView()]);


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
        //service в папке src для mailerservice
        /** @var Swift_Mailer $mailer */
        $mailer = Swift_Mailer::class;
        /** @var EntityRepository $managers */
        $managers = $this->getDoctrine()->getRepository(Manager::class);
        /** @var ArrayCollection $managers */
        $managers = $managers->matching(new Criteria(Criteria::expr()->andX(
            Criteria::expr()->eq('branch', $newManager->getBranch()),
            Criteria::expr()->neq('id', $newManager->getId()),
            Criteria::expr()->neq('email', null)
        ))); //////////?????????????/

        $emailsArray = $managers->map(
            static function(Manager $manager) {
                return $manager->getEmail();
            }
        );
        /** @var Swift_Message $message */
        $message = (new Swift_Message('Welcome email'))
            ->setFrom('general@mail.ru')
            ->setTo($emailsArray->toArray())
            ->setBody(
                $this->renderView(
                    'Email/welcome.txt.twig',
                    ['newManager' => $newManager]));
        var_dump($message);
        return $mailer->send($message);
    }

    //$this->addFlash(type,text)
    // при добавлении менеджера уведомить весь отдел
    //asasdas

}