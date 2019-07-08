<?php

namespace App\Renderer;

use App\Offer\Calculation;
use App\Offer\Offer;
use App\Twig\AppExtension;
use Knp\Snappy\Pdf;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class PdfOfferRenderer
{
    private $pdf;
    private $twig;
    private $templatePath;

    public function __construct(string $templatePath, string $helperPath,
                                Pdf $pdf, AppExtension $extension, bool $debug)
    {
        $this->pdf = $pdf;
        $this->templatePath = $templatePath;

        $this->twig = new Environment(
            new FilesystemLoader([$templatePath, $helperPath]),
            ['strict_variables' => $debug, 'debug' => $debug]
        );
        $this->twig->addExtension($extension);
        $this->twig->addFunction(new TwigFunction('path', function($filename){
            echo $this->templatePath . DIRECTORY_SEPARATOR . $filename;
        }));
    }

    public function setOfferData(Offer $offer, Calculation $calculation)
    {
        $this->twig->addGlobal('offer', $offer);
        $this->twig->addGlobal('calculation', $calculation);
    }

    public function generate()
    {
        $renderedPages = [];

        foreach (range(1, 100) as $i) {
            $template = sprintf('page-%d.html.twig', $i);

            if ($this->twig->getLoader()->exists($template)) {
                $renderedPages[] = $this->twig->render($template);
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
