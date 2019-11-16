<?php

namespace App\Factory;

use App\Model\Offer;
use App\Model\Recipient;
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

        $offer->setItems(
            $this->itemRespository->findAllEnabledByDefault()
        );
        $offer->setDiscounts(
            $this->discountRespository->findAllEnabledByDefault()
        );

        return $offer;
    }

    public function createPreviewOffer(): Offer
    {
        $offer = $this->createBlankOffer();

        $offer->setAuthor(
            $this->authorRespository->findOneBy([])
        );
        $offer->setDiscounts(
            $this->discountRespository->findAll()
        );
        $offer->setItems(
            $this->itemRespository->findAll()
        );

        $offer->getRecipient()
            ->setCompany('Company Corp.')
            ->setName('John Smith')
        ;

        return $offer;
    }
}
