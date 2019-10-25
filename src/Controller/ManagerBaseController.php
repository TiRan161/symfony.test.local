<?php


namespace App\Controller;


use App\Entity\Branch;
use App\Entity\Manager;
use App\Form\BranchFormType;
use App\Form\ManagerFormType;
use phpDocumentor\Reflection\Location;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ManagerBaseController extends AbstractController
{
    public function writeBranch(Request $request)
    {
        $newBranch = new Branch();
        $form = $this->createForm(BranchFormType::class, $newBranch);
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

    public function editBranch(Request $request, Branch $branch)
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

    public function editManager(Request $request, Manager $manager)
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


    public function writeManager(Request $request)
    {
        $newManager = new Manager();
        $form = $this->createForm(ManagerFormType::class, $newManager);
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
}