<?php

namespace App\Controller;

use App\Entity\Volgenerique;
use App\Form\VolgeneriqueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/volgenerique")
 */
class VolgeneriqueController extends AbstractController
{
    /**
     * @Route("/", name="app_volgenerique_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $volgeneriques = $entityManager
            ->getRepository(Volgenerique::class)
            ->findAll();

        return $this->render('volgenerique/index.html.twig', [
            'volgeneriques' => $volgeneriques,
        ]);
    }

    /**
     * @Route("/new", name="app_volgenerique_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $volgenerique = new Volgenerique();
        $form = $this->createForm(VolgeneriqueType::class, $volgenerique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($volgenerique);
            $entityManager->flush();

            return $this->redirectToRoute('app_volgenerique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('volgenerique/new.html.twig', [
            'volgenerique' => $volgenerique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_volgenerique_show", methods={"GET"})
     */
    public function show(Volgenerique $volgenerique): Response
    {
        return $this->render('volgenerique/show.html.twig', [
            'volgenerique' => $volgenerique,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_volgenerique_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Volgenerique $volgenerique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VolgeneriqueType::class, $volgenerique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_volgenerique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('volgenerique/edit.html.twig', [
            'volgenerique' => $volgenerique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_volgenerique_delete", methods={"POST"})
     */
    public function delete(Request $request, Volgenerique $volgenerique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$volgenerique->getId(), $request->request->get('_token'))) {
            $entityManager->remove($volgenerique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_volgenerique_index', [], Response::HTTP_SEE_OTHER);
    }
}
