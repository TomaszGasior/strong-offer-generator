<?php

namespace App\Controller;

use App\Entity\Discount;
use App\Form\DiscountEditType;
use App\Repository\DiscountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscountController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/rabaty", name="discount.list")
     */
    public function list(DiscountRepository $discountRepository): Response
    {
        return $this->render('app/manage/discounts-list.html.twig', [
            'discounts' => $discountRepository->findAll(),
        ]);
    }

    /**
     * @Route("/rabat/nowy", name="discount.create")
     */
    public function create(Request $request): Response
    {
        $discount = new Discount;

        $form = $this->createForm(DiscountEditType::class, $discount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($discount);
            $this->entityManager->flush();

            return $this->redirectToRoute('discount.list');
        }

        return $this->render('app/manage/discount-create.html.twig', [
            'form' => $form->createView(),
            'discount' => $discount,
        ]);
    }

    /**
     * @Route("/rabat/{id}", name="discount.edit")
     */
    public function edit(Discount $discount, Request $request): Response
    {
        $form = $this->createForm(DiscountEditType::class, $discount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('discount.list');
        }

        return $this->render('app/manage/discount-edit.html.twig', [
            'form' => $form->createView(),
            'discount' => $discount,
        ]);
    }

    /**
     * @Route("/rabat/{id}/usun", name="discount.delete")
     */
    public function delete(Discount $discount): Response
    {
        $this->entityManager->remove($discount);
        $this->entityManager->flush();

        return $this->redirectToRoute('discount.list');
    }
}
