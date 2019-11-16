<?php

namespace App\Controller;

use App\Factory\OfferFactory;
use App\Form\GeneratorJobType;
use App\Model\Offer;
use App\Model\Recipient;
use App\Renderer\PdfOfferRenderer;
use App\Util\Calculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class GeneratorController extends AbstractController
{
    /**
     * @Route("/")
     * @Route("/generator", name="generator.form")
     */
    public function form(Request $request, PdfOfferRenderer $renderer, OfferFactory $factory): Response
    {
        $offer = $factory->createBlankOffer();
        $calculation = new Calculator($offer);

        $renderer->setOfferData($offer, $calculation);

        $form = $this->createForm(GeneratorJobType::class, $offer, ['method' => 'GET']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $response = new Response($renderer->generate());

            $filename = sprintf(
                'Oferta %s' . '.pdf',
                str_replace(['/', '\\'], '', $offer->getRecipient()->getCompany())
            );
            $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename, date('Y-m-d').'.pdf'
            ));
            $response->headers->set('Content-Type', 'application/pdf');

            return $response;
        }

        return $this->render('app/generator-form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
