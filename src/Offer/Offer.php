<?php

namespace App\Offer;

use App\Entity\Author;
use App\Entity\Discount;
use App\Entity\Item;
use Symfony\Component\Validator\Constraints as Assert;

class Offer
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $company;

    /**
     * @Assert\NotBlank
     * @Assert\Type(Author::class)
     */
    private $author;

    /**
     * @Assert\Type("array")
     * @Assert\All({@Assert\Type(Discount::class)})
     */
    private $discounts = [];

    /**
     * @Assert\NotBlank
     * @Assert\Type("array")
     * @Assert\All({@Assert\Type(Item::class)})
     */
    private $items = [];

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDiscounts(): ?array
    {
        return $this->discounts;
    }

    public function setDiscounts(array $discounts): self
    {
        $this->discounts = $discounts;

        return $this;
    }

    public function getItems(): ?array
    {
        return $this->items;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }
}
