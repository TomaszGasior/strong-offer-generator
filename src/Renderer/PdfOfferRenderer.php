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
    private $templatePath;
    private $helperPath;

    public function __construct(Pdf $pdf, Environment $twig, string $templatePath, string $helperPath)
    {
        $this->pdf = $pdf;
        $this->twig = $twig;
        $this->templatePath = $templatePath;
        $this->helperPath = $helperPath;
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
        $savedCache = $this->twig->getCache();

        $loader->setPaths([$this->templatePath, $this->helperPath]);
        $this->twig->setCache(false);

        $ret = $this->render();

        $loader->setPaths($savedPaths);
        $this->twig->setCache($savedCache);

        return $ret;
    }

    protected function render()
    {
        $renderedPages = [];

        $variables = [
            'offer' => $this->offer,
            'calculation' => $this->calculation,
        ];
        foreach (range(1, 100) as $i) {
            $template = sprintf('page-%d.html.twig', $i);

            if ($this->twig->getLoader()->exists($template)) {
                $renderedPages[] = $this->twig->render($template, $variables);
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
