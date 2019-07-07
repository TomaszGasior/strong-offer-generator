<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemEditType;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/pozycje", name="item.list")
     */
    public function list(ItemRepository $itemRepository): Response
    {
        return $this->render('app/manage/items-list.html.twig', [
            'items' => $itemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/pozycja/nowa", name="item.create")
     */
    public function create(Request $request): Response
    {
        $item = new Item;

        $form = $this->createForm(ItemEditType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($item);
            $this->entityManager->flush();

            return $this->redirectToRoute('item.list');
        }

        return $this->render('app/manage/item-create.html.twig', [
            'form' => $form->createView(),
            'item' => $item,
        ]);
    }

    /**
     * @Route("/pozycja/{id}", name="item.edit")
     */
    public function edit(Item $item, Request $request): Response
    {
        $form = $this->createForm(ItemEditType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('item.list');
        }

        return $this->render('app/manage/item-edit.html.twig', [
            'form' => $form->createView(),
            'item' => $item,
        ]);
    }

    /**
     * @Route("/pozycja/{id}/usun", name="item.remove")
     */
    public function remove(Item $item): Response
    {
        $this->entityManager->remove($item);
        $this->entityManager->flush();

        return $this->redirectToRoute('item.list');
    }
}
