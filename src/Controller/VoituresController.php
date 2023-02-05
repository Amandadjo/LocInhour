<?php

namespace App\Controller;

use App\Entity\Voitures;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoituresController extends AbstractController
{
    /**
     * @Route("/voitures", name="app_voitures")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $voitures = $doctrine->getRepository(Voitures::class)->findAll();
        return $this->render('voitures/index.html.twig', [
            'voitures' => $voitures,
        ]);
        
    }

    /**
     * @Route("/voitures/{id}", name="voitures_show", requirements={"id"="\d+"})
     */
    public function show($id, ManagerRegistry $doctrine): Response
    {
        $voiture = $doctrine->getRepository(Voitures::class)->find($id);
        return $this->render('voitures/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }
}
