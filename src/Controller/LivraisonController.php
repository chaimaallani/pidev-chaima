<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Form\LivraisonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class LivraisonController extends AbstractController
{
    /**
     * @Route("/livraison", name="livraison")
     */
    public function index(): Response
    {
        return $this->render('livraison/index.html.twig', [
            'controller_name' => 'LivraisonController',
        ]);
    }

    /**
     * @Route("/listLivraison", name="listLivraison")
     */
    public function listLivraison()
    {
        $livraison = $this->getDoctrine()->getRepository(Livraison::class)->findAll();
        return $this->render('livraison/listLivraison.html.twig', ["livraison" => $livraison]);
    }

    /**
     * @Route("/AfficheLivraison/{id}", name="AfficheLivraison")
     */
    public function AfficheLivraison(Request $request, $id){
        $repository=$this->getDoctrine()->getRepository(Livraison::class);
        $livraison=$repository->find($id);
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->add("Consulter les livraisons", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($livraison);
            $em->flush();
            return $this->redirectToRoute('listLivraison');
        }
        return $this->render('livraison/AfficheLivraison.html.twig', ['livraison'=>$livraison]);
    }

    /**
     * @Route("/ajouterLivraison", name="ajouterLivraison")
     */
    public function ajouterLivraison(Request $request)
    {
        $livraison = new Livraison();
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->add("Ajouter", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($livraison);
            $em->flush();
            return $this->redirectToRoute('listLivraison');
        }
        return $this->render("livraison/ajouter.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/supprimerLivraison/{id}", name="supprimerLivraison")
     */
    public function supprimerLivraison($id)
    {
        $livraison = $this->getDoctrine()->getRepository(Livraison::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($livraison);
        $em->flush();
        return $this->redirectToRoute("listLivraison");
    }

    /**
     * @Route("/modifierLivraison/{id}", name="modifierLivraison")
     */
    public function modifierLivraison(Request $request, $id)
    {
        $livraison = $this->getDoctrine()->getRepository(Livraison::class)->find($id);
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listLivraison');
        }
        return $this->render("livraison/modifier.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/ImprimerLivraison", name="ImprimerLivraison")
     */
    public function ImprimerLivraison(){
        $repository=$this->getDoctrine()->getRepository(Livraison::class);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $livraison=$repository->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('livraison/listLivraison.html.twig',
            ['livraison'=>$livraison]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Livraison_finale.pdf", [
            "Attachment" => true
        ]);


    }



}
