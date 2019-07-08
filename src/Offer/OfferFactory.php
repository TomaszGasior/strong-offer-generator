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
}
