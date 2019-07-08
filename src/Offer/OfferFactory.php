<?php

namespace App\Offer;

use App\Offer\Recipient;
use App\Repository\AuthorRepository;
use App\Repository\DiscountRepository;
use App\Repository\ItemRepository;

class OfferFactory
{
    private const DEFAULT_EXPIRATION_DAYS = 14;

    private $itemRespository;
    private $discountRespository;
    private $authorRespository;

    public function __construct(ItemRepository $itemRespository,
                                DiscountRepository $discountRespository,
                                AuthorRepository $authorRespository)
    {
        $this->itemRespository = $itemRespository;
        $this->discountRespository = $discountRespository;
        $this->authorRespository = $authorRespository;
    }

    public function createBlankOffer(): Offer
    {
        $offer = new Offer;

        $offer->setRecipient(new Recipient);
        $offer->setExpirationDate(
            new \DateTime(sprintf('+%d days', self::DEFAULT_EXPIRATION_DAYS))
        );

        return $offer;
    }

    public function createPreviewOffer(): Offer
    {
        $offer = $this->createBlankOffer();

        $author = $this->authorRespository->findOneBy([]);
        $discounts = $this->discountRespository->findAll();
        $items = $this->itemRespository->findAll();

        $offer->setAuthor($author);
        $offer->setDiscounts($discounts);
        $offer->setItems($items);

        $offer->getRecipient()->setCompany('Company Corp.');
        $offer->getRecipient()->setName('John Smith');

        return $offer;
    }
}
