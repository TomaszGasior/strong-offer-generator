<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorEditType;
use App\Form\DeleteConfirmType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/osoby", name="author.list")
     */
    public function list(AuthorRepository $authorRepository): Response
    {
        return $this->render('app/manage/authors-list.html.twig', [
            'authors' => $authorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/osoba/nowa", name="author.create")
     */
    public function create(Request $request): Response
    {
        $author = new Author;

        $form = $this->createForm(AuthorEditType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($author);
            $this->entityManager->flush();

            return $this->redirectToRoute('author.edit', ['id' => $author->getId()]);
        }

        return $this->render('app/manage/author-create.html.twig', [
            'form' => $form->createView(),
            'author' => $author,
        ]);
    }

    /**
     * @Route("/osoba/{id}", name="author.edit")
     */
    public function edit(Author $author, Request $request): Response
    {
        $form = $this->createForm(AuthorEditType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return $this->render('app/manage/author-edit.html.twig', [
            'form' => $form->createView(),
            'author' => $author,
        ]);
    }

    /**
     * @Route("/osoba/{id}/usun", name="author.delete")
     */
    public function delete(Author $author, Request $request): Response
    {
        $form = $this->createForm(DeleteConfirmType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->remove($author);
            $this->entityManager->flush();

            return $this->redirectToRoute('author.list');
        }

        return $this->render('app/manage/author-delete.html.twig', [
            'form' => $form->createView(),
            'author' => $author,
        ]);
    }
}
