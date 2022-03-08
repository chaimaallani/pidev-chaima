<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Commande;
use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{
    /**
     * @Route("/avis", name="avis")
     */
    public function index(): Response
    {
        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
        ]);
    }

    /**
     * @Route("/listAvis", name="listAvis")
     */
    public function listAvis()
    {
        $commandes = $this->getDoctrine()->getRepository(Avis::class)->findAll();
        return $this->render('avis/listAvis.html.twig', ["avis" => $avis]);
    }

    /**
     * @Route("/ajouterAvis", name="ajouterAvis")
     */
    public function ajouterAvis(Request $request)
    {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);
        $form->add("Ajouter", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($avis);
            $em->flush();
            return $this->redirectToRoute('listAvis');
        }
        return $this->render("avis/ajouter.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/supprimerAvis/{id}", name="supprimerAvis")
     */
    public function supprimerAvis($id)
    {
        $commande = $this->getDoctrine()->getRepository(Avis::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();
        return $this->redirectToRoute('listAvis');
    }

    /**
     * @Route("/modifierAvis/{id}", name="modifierAvis")
     */
    public function modifierAvis(Request $request, $id)
    {
        $commande = $this->getDoctrine()->getRepository(Avis::class)->find($id);
        $form = $this->createForm(AvisType::class, $avis);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listAvis');
        }
        return $this->render("avis/modifier.html.twig", array('form' => $form->createView()));
    }
}
