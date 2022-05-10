<?php

namespace App\Controller;

use App\Entity\Vol;
use App\Entity\Reservation;
use App\Entity\Facture;
use App\Form\VolType;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

use Symfony\Component\Form\FormError;

/**
 * @Route("/vol")
 */
class VolController extends AbstractController
{
    /**
     * @Route("/", name="app_vol_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $vols = $entityManager
            ->getRepository(Vol::class)
            ->findAll();

        return $this->render('vol/index.html.twig', [
            'vols' => $vols,
        ]);
    }

    /**
     * @Route("/expiree", name="vol_index_inf", methods={"GET"})
     */
    public function indexinf(EntityManagerInterface $entityManager): Response
    {
        

        $query = $entityManager->createQuery(
            'SELECT v
            FROM App\Entity\Vol v
            WHERE v.dateArrivee < :nowt
            '
        )->setParameter('nowt', (new \DateTime()));

        // returns an array of Product objects
     

        return $this->render('vol/index.html.twig', [
            'vols' => $query->getResult(),
        ]);
    

      
    }
    /**
     * @Route("/encours", name="vol_index_encours", methods={"GET"})
     */
    public function indexencour(EntityManagerInterface $entityManager): Response
    {
       

        $query = $entityManager->createQuery(
            'SELECT v
            FROM App\Entity\Vol v
            WHERE v.dateArrivee > :nowt
            '
        )->setParameter('nowt', (new \DateTime()));     

        return $this->render('vol/index.html.twig', [
            'vols' => $query->getResult(),
        ]);
    

      
    }

    /**
     * @Route("/new", name="app_vol_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        date_default_timezone_set("Europe/Berlin");
        $vol = new Vol();
        $form = $this->createForm(VolType::class, $vol);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $datedep=$form["dateDepart"]->getData();
            $datedari=$form["dateArrivee"]->getData();
            $datenow= new \DateTime('now');
          // dump($datenow);
           //die();
            
            if($datedep>=$datedari){
                $dateError = new FormError("Choisir une date superieure a la date de depart");
                $form["dateArrivee"]->addError($dateError);
                return $this->render('vol/new.html.twig', [
                    'vol' => $vol,
                    'form' => $form->createView(),
                ]);
            }
            if($datedep<$datenow){
                $dateError = new FormError("Choisir une date superieure ou egale a la date d'aujourd'hui");
                $form["dateDepart"]->addError($dateError);
                return $this->render('vol/new.html.twig', [
                    'vol' => $vol,
                    'form' => $form->createView(),
                ]);
                
            }
            
            $vol->setNbrreserve(0);
            $entityManager->persist($vol);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vol/new.html.twig', [
            'vol' => $vol,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_vol_show", methods={"GET"})
     */
    public function show(Vol $vol): Response
    {
        return $this->render('vol/show.html.twig', [
            'vol' => $vol,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_vol_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Vol $vol, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VolType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vol/edit.html.twig', [
            'vol' => $vol,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_vol_delete", methods={"POST"})
     */
    public function delete(Request $request, Vol $vol, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vol->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vol);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/client/index", name="app_vol_client", methods={"GET"})
     */
    public function client(EntityManagerInterface $entityManager): Response
    {
        $vols = $entityManager
            ->getRepository(Vol::class)
            ->findAll();

        return $this->render('vol/vol_client.html.twig', [
            'vols' => $vols,
        ]);
    }

    /**
     * @Route("/client/reservation/{id}", name="app_vol_reservation", methods={"GET", "POST"})
     */
    public function clientReservation(Request $request,EntityManagerInterface $entityManager,Vol $vol,\Swift_Mailer $mailer): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $user=$this->getUser();
            $reservation->setIduser($user->getId());

            //$montant=$form["vol"]->getData()->getMontant();
            $reservation->setVol($vol);
        $facture= new Facture();
        $facture->setNbr($reservation->getNbr());
        $facture->setPrixUnitaire($vol->getMontant());
        $facture->setPrixTotal($vol->getMontant()*$reservation->getNbr());
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
            return $this->redirectToRoute('app_facture_client', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vol/single.html.twig', [
            'vol' => $vol,
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @var \DateTimeZone
     */
    private static $utc;
    private static function getUtc(): \DateTimeZone
    {
        return self::$utc ?: self::$utc = new \DateTimeZone('UTC +2');
    }
}
