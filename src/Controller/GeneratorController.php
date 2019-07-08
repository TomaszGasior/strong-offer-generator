<?php

namespace App\Controller;

use App\Form\GeneratorJobType;
use App\Offer\Calculation;
use App\Offer\Offer;
use App\Offer\OfferFactory;
use App\Offer\Recipient;
use App\Renderer\PdfOfferRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class GeneratorController extends AbstractController
{
    private $pdfFilePattern;

    public function __construct(?string $pdfFilePattern)
    {
        $this->pdfFilePattern = $pdfFilePattern;
    }

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
    public function form(Request $request, PdfOfferRenderer $renderer, OfferFactory $factory): Response
    {
        $offer = $factory->createBlankOffer();
        $calculation = new Calculation($offer);

        $renderer->setOfferData($offer, $calculation);

        $form = $this->createForm(GeneratorJobType::class, $offer, ['method' => 'GET']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $response = new Response($renderer->generate());

            if ($this->pdfFilePattern) {
                $filename = sprintf(
                    $this->pdfFilePattern . '.pdf',
                    str_replace(['/', '\\'], '', $offer->getRecipient()->getCompany())
                );
            }
            $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename ?? null, date('Y-m-d').'.pdf'
            ));
            $response->headers->set('Content-Type', 'application/pdf');

            return $response;
        }

        return $this->render('app/generator-form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
