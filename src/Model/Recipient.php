<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Recipient
{
    /**
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $company;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }
}
