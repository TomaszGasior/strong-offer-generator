<?php

namespace App\Controller;

use App\Form\GeneratorJobType;
use App\Offer\Calculation;
use App\Offer\Offer;
use App\Renderer\PdfOfferRenderer;
use App\Repository\AuthorRepository;
use App\Repository\DiscountRepository;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PreviewController extends AbstractController
{
    private $authorRespository;
    private $discountRespository;
    private $itemRespository;

    public function __construct(AuthorRepository $authorRespository,
                                DiscountRepository $discountRespository,
                                ItemRepository $itemRespository)
    {
        $this->authorRespository = $authorRespository;
        $this->discountRespository = $discountRespository;
        $this->itemRespository = $itemRespository;
    }

    /**
     * @Route("/podglad")
     */
    public function preview(Request $request, PdfOfferRenderer $renderer): Response
    {
        $offer = new Offer;
        $calculation = new Calculation($offer);

        $renderer->setOfferData($offer, $calculation);

        $this->setUpFakeData($offer);

        $response = new Response($renderer->generate());
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }

    private function setUpFakeData(Offer $offer): void
    {
        $authors = $this->authorRespository->findAll();
        $discounts = $this->discountRespository->findAll();
        $items = $this->itemRespository->findAll();

        $offer->setAuthor($authors[0]);
        $offer->setDiscounts($discounts);
        $offer->setItems($items);

        $offer->setCompany('Company');
    }
}
