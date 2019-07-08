<?php

namespace App\Controller;

use App\Form\GeneratorJobType;
use App\Offer\Calculation;
use App\Offer\Offer;
use App\Offer\OfferFactory;
use App\Renderer\PdfOfferRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PreviewController extends AbstractController
{
    /**
     * @Route("/podglad")
     * @Route("/generator/podglad")
     */
    public function preview(PdfOfferRenderer $renderer, OfferFactory $factory): Response
    {
        $offer = $factory->createPreviewOffer();
        $calculation = new Calculation($offer);

        $renderer->setOfferData($offer, $calculation);

        $response = new Response($renderer->generate());
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
}
