<?php

namespace App\Controller;


use App\Entity\Reservation;
use App\Entity\Voitures;
use App\Form\ReservationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation/{id}", name="app_reservation")
     */
    public function index($id, Request $request, ManagerRegistry $doctrine)
    {
        $voiture = $doctrine->getRepository(Voitures::class)->find($id);
        
        #ETAPE 1 : créer un objet vide
        $reservation = new Reservation();
        #ETAPE 2 : Mettre des valeurs par défaut, si besoin

        #ETAPE 3 : création d'un formulaire avec la méthode 2 : createForm()
        $formReservation = $this->createForm(ReservationType::class, $reservation);

        $formReservation->handleRequest($request);
        if($formReservation->isSubmitted() && $formReservation->isValid()) 
        {
            $entityManager = $doctrine->getManager();
            $reservation->setVoitures($voiture);
            $diff = $reservation->getFinReservation()->diff($reservation->getDateReservation());
            
            $hours = (int) $diff->h;
            $days = (int) $diff->days;
            $dateDiff = $hours + ($days * 24);

            $reservation->setDureeLocation((string)$dateDiff);
            $reservation->setTarifLocation($dateDiff * $voiture->getPrix());
            $reservation->setVoitures($voiture);

            $entityManager->persist($reservation);
            $entityManager->flush();

            #Enregistrer un message flash
            $this->addFlash('success', "Votre réservation a bien été effectuée !");

            return $this->redirectToRoute('app_confirmation', ["id" => $reservation->getId()]); //voir ici c'était get id
        }

        #ETAPE 4 : générer le formulaire dans la vue
        return $this->render('reservation/index.html.twig', [
            'formReservation' => $formReservation->createView(),
            'voiture' => $voiture,
        ]);
    }

    
}
