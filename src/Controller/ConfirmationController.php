<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Voitures;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmationController extends AbstractController
{
    /**
     * @Route("/confirmation/{id}", name="app_confirmation")
     */
    public function index($id, Request $request, ManagerRegistry $doctrine)
    {   
        $reservation = $doctrine->getRepository(Reservation::class)->find($id);
        $voiture = $reservation->getVoitures();
        return $this->render('confirmation/index.html.twig', [
            'reservation' => $reservation,
            'voiture'=> $voiture
        ]);
    }
}
