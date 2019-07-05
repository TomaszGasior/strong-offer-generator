<?php

namespace App\Controller;

use App\Form\GeneratorJobType;
use App\Offer\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeneratorController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('generator.form');
    }

    /**
     * @Route("/generator", name="generator.form")
     */
    public function form(Request $request): Response
    {
        $offer = new Offer;

        $form = $this->createForm(GeneratorJobType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($offer);
        }

        return $this->render('app/generator-form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
