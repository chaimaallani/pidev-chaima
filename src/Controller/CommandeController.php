<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(): Response
    {
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }

    /**
     * @Route("/listCommande", name="listCommande")
     */
    public function listCommande()
    {
        $commandes = $this->getDoctrine()->getRepository(Commande::class)->findAll();
        return $this->render('commande/listCommande.html.twig', ["commandes" => $commandes]);
    }

    /**
     * @Route("/ajouterCommande", name="ajouterCommande")
     */
    public function ajouterCommande(Request $request)
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->add("Ajouter", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();
            return $this->redirectToRoute('listCommande');
        }
        return $this->render("commande/ajouter.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/supprimerCommande/{id}", name="supprimerCommande")
     */
    public function supprimerCommande($id)
    {
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();
        return $this->redirectToRoute('listCommande');
    }

    /**
     * @Route("/modifierCommande/{id}", name="modifierCommande")
     */
    public function modifierCommande(Request $request, $id)
    {
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        $form = $this->createForm(CommandeType::class, $commande);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listCommande');
        }
        return $this->render("commande/modifier.html.twig", array('form' => $form->createView()));
    }


    /**
     * @Route("/triid", name="triid")
     */

    public function Triid(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT c FROM App\Entity\Commande c 
            ORDER BY c.date_c'
        );
        $rep = $query->getResult();

        return $this->render('commande/listCommande.html.twig',
            array('commande' => $rep));
}
}
