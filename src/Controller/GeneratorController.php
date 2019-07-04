<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function form(): Response
    {
        return new Response;
    }
}
