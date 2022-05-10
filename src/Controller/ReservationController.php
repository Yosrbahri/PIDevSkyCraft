<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Facture;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\FormError;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="app_reservation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/new", name="app_reservation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,\Swift_Mailer $mailer): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation,["admin"=>true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $user=$this->getUser();
           $reservation->setIduser($user->getId());
            $vol=$form["vol"]->getData();
            $montant=$form["vol"]->getData()->getMontant();
            $nbrdispo=$form["vol"]->getData()->getNbrdispo();
            $nbrrese=$form["vol"]->getData()->getNbrreserve();

            $tot=$nbrrese+$form["nbr"]->getData();
            if($tot>$nbrdispo){
                $dateError = new FormError("il reste que".$nbrdispo- $nbrrese."places");
                $form["nbr"]->addError($dateError);
                return $this->render('reservation/new.html.twig', [
                    'reservation' => $reservation,
                    'form' => $form->createView(),
                ]);
            }
            else{
                $vol->setNbrreserve($nbrrese+$form["nbr"]->getData());
                $entityManager->flush();
            }
        $facture= new Facture();
        $facture->setNbr($reservation->getNbr());
        $facture->setPrixUnitaire($montant);
        $facture->setPrixTotal($montant*$reservation->getNbr());
        //$facture->setReservation($reservation);
       $facture->setIduser($user->getId());
        $entityManager->persist($facture);
        $entityManager->flush();
        $entityManager->persist($reservation);
        $entityManager->flush();

        $message = (new \Swift_Message('Reservation effectuer'))
        ->setFrom('skycraft.noreply123@gmail.com')
        ->setTo($user->getEmail())
        ->setBody(
            $this->renderView(
                // templates/hello/email.txt.twig
                'emails/email.html.twig',
                ['datereservation' => $reservation->getDateReservation(),
                'facture'=> $facture->getPrixTotal()
            ]
            ),'text/html'
        )
    ;
    $mailer->send($message);
            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_reservation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();
            
            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
