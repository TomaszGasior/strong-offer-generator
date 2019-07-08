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
    private $templatePaths;

    public function __construct(Pdf $pdf, Environment $twig, array $templatePaths)
    {
        $this->pdf = $pdf;
        $this->twig = $twig;
        $this->templatePaths = $templatePaths;
    }

    public function setOfferData(Offer $offer, Calculation $calculation)
    {
        $this->offer = $offer;
        $this->calculation = $calculation;
    }

    public function generate()
    {
        $loader = $this->twig->getLoader();
        $savedPaths = $loader->getPaths();

        $loader->setPaths($this->templatePaths);
        $ret = $this->render();
        $loader->setPaths($savedPaths);

        return $ret;
    }

    protected function render()
    {
        $renderedPages = [];

        $variables = [
            'offer' => $this->offer,
            'calculation' => $this->calculation,
        ];
        foreach (range(1, 25) as $i) {
            try {
                $renderedPages[] = $this->twig->render('page-'.$i.'.html.twig', $variables);
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
