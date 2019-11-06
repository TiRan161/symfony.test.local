<?php


namespace App\Controller;


use App\Entity\Branch;
use App\Entity\Manager;
use App\Form\BranchFormType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BranchViewController extends AbstractController
{
    private function formatBranch($request, Branch $branch)
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

}