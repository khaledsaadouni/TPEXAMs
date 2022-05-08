<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Pfe;
use App\Form\PfeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/pfe')]
class PfeController extends AbstractController
{
    #[Route('/add/{id?0}', name: 'add')]
    public function addPfe(ManagerRegistry $doctrine,Request $request,Pfe $pfe=null): Response
    {
        if(!$pfe){
            $pfe=new PFE();
        }
        $manager=$doctrine->getManager();
        $form=$this->createForm(PfeType::class,$pfe);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $manager->persist($pfe);
            $manager->flush();
            $this->addFlash('success','Pfe added successfuly');
            return $this->redirectToRoute('detail',[
                'id'=>$pfe->getId()
            ]);
        }
        else{

            return $this->render('pfe/add.html.twig', [
                'form'=>$form->createView()
            ]);
        }
    }
    #[Route('/detail{id?0}', name: 'detail')]
    public function showDetails(ManagerRegistry $doctrine,$id):Response{
        $repository=$doctrine->getRepository(Pfe::class);
        $pfe=$repository->findOneBy(['id'=>$id]);
        if($pfe){
            return $this->render('pfe/detail.html.twig',[
                'pfe'=>$pfe
            ]);
        }
            $this->addFlash('error','pfe not found');
            return $this->redirectToRoute('add');
    }

    #[Route('/ent', name: 'entreprise')]
    public function aff(ManagerRegistry $doctrine): Response
    {
        $repo=$doctrine->getRepository(Entreprise::class);
        $l=$repo->findAll();

        return $this->render('pfe/aff.html.twig', [
            'list' =>$l,
        ]);

    }
    #[Route('/all', name: 'list')]
    public function index(ManagerRegistry $doctrine):Response{
        $repository=$doctrine->getRepository(PFE::class);
        $pfes=$repository->findAll();
        return $this->render('pfe/index.html.twig',['list'=>$pfes]);
    }
}
