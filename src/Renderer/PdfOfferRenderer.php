<?php

namespace App\Renderer;

use App\Offer\Calculation;
use App\Offer\Offer;
use Knp\Snappy\Pdf;
use Twig\Environment;
use Twig\Error\LoaderError;

class PdfOfferRenderer
{
    private $pdf;
    private $twig;
    private $offer;
    private $calculation;

    public function __construct(Pdf $pdf, Environment $twig)
    {
        $this->pdf = $pdf;
        $this->twig = $twig;
    }

    public function setOfferData(Offer $offer, Calculation $calculation)
    {
        $this->offer = $offer;
        $this->calculation = $calculation;
    }

    public function generate()
    {
        $renderedPages = [];

        $variables = [
            'offer' => $this->offer,
            'calculation' => $this->calculation,
        ];
        foreach (range(1, 25) as $i) {
            try {
                $renderedPages[] = $this->twig->render('offer_pdf/page-'.$i.'.html.twig', $variables);
            } catch (LoaderError $e) {
                continue;
            }
        }

        $settings = [
            'margin-bottom' => 0,
            'margin-left' => 0,
            'margin-right' => 0,
            'margin-top' => 0,
            'no-outline' => true,
            'page-size' => 'A4',
            'zoom' => 1.25,
        ];
        return $this->pdf->getOutputFromHtml($renderedPages, $settings);
    }
}
