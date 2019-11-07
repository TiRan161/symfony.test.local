<?php


namespace App\Controller;


use App\Entity\Manager;
use App\Service\MailService;
use App\Service\SupportService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ManagerFormType;

class ManagerViewController extends AbstractController
{
    private $mailService;
    private $supportService;

    public function __construct(MailService $mailService, SupportService $supportService)
    {
        $this->mailService = $mailService;
        $this->supportService = $supportService;
    }

    public function writeManager(Request $request)
    {
        $manager = new Manager();
        return $this->formatManager($request, $manager, true);
    }

    public function editManager(Request $request, Manager $manager)
    {
        return $this->formatManager($request, $manager, false);
    }

    private function formatManager(Request $request, Manager $manager, bool $newEntry)
    {
        $form = $this->createForm(ManagerFormType::class, $manager);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form['photo']->getData();
            $path = $this->getParameter('kernel.project_dir') . '/public/uploads/photo/';
            $publicPath = '/uploads/photo/';
            $fileName = "{$photoFile->getFilename()}.{$photoFile->getClientOriginalExtension()}";
            $photoFile->move($path, $fileName);
            $manager->setPhoto($publicPath . $fileName);
            $em = $this->getDoctrine()->getManager();
            if ($newEntry === true) {
                $a = $this->supportService->getUuid();
                $manager->setCode($this->supportService->getUuid());
                $em->persist($manager);
            }
            $em->flush();
            $this->sendEmails($manager);
            return $this->redirectToRoute('get_data');
        }
        return $this->render('index/writeManager.html.twig', ['manager' => $form->createView()]);
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

}