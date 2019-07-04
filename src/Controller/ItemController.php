<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    /**
     * @Route("/pozycje", name="item.list")
     */
    public function list(ItemRepository $itemRepository): Response
    {
        return new Response;
    }

    /**
     * @Route("/pozycja/nowa", name="item.create")
     */
    public function create(): Response
    {
        return new Response;
    }

    /**
     * @Route("/pozycja/{id}", name="item.edit")
     */
    public function edit(Item $item): Response
    {
        return new Response;
    }

    /**
     * @Route("/pozycja/{id}/usun", name="item.remove")
     */
    public function remove(Item $item): Response
    {
        return new Response;
    }
}
