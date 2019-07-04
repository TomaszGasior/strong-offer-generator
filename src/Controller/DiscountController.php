<?php

namespace App\Controller;

use App\Entity\Discount;
use App\Repository\DiscountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscountController extends AbstractController
{
    /**
     * @Route("/rabaty", name="discount.list")
     */
    public function list(DiscountRepository $discountRepository): Response
    {
        return new Response;
    }

    /**
     * @Route("/rabat/nowy", name="discount.create")
     */
    public function create(): Response
    {
        return new Response;
    }

    /**
     * @Route("/rabat/{id}", name="discount.edit")
     */
    public function edit(Discount $discount): Response
    {
        return new Response;
    }

    /**
     * @Route("/rabat/{id}/usun", name="discount.remove")
     */
    public function remove(Discount $discount): Response
    {
        return new Response;
    }
}
