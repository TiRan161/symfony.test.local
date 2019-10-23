<?php


namespace App\Controller;


use App\Entity\Branch;
use App\Form\BranchFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ManagerBaseController extends AbstractController
{
    public function writeBranch(Request $request)
    {
        $form = $this->createForm(BranchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $branch = new Branch;
            $branch->setName($form->getData()['name']);
            $em = $this->getDoctrine()->getManager();
            var_dump($em);
//            if(!$em->contains($em))
//            $em->persist($branch);
//            $em->flush();
        }
//        $branch = new Branch();
//        $branch->setName('Отдел информационных технологий');
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($branch);
//        $em->flush();
        return $this->render('index/writeBranch.html.twig', ['branch' => $form->createView()]);

    }
}