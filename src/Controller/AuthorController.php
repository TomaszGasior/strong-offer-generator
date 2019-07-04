<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/osoby", name="author.list")
     */
    public function list(AuthorRepository $authorRepository): Response
    {
        return new Response;
    }

    /**
     * @Route("/osoba/nowa", name="author.create")
     */
    public function create(): Response
    {
        return new Response;
    }

    /**
     * @Route("/osoba/{id}", name="author.edit")
     */
    public function edit(Author $author): Response
    {
        return new Response;
    }

    /**
     * @Route("/osoba/{id}/usun", name="author.remove")
     */
    public function remove(Author $author): Response
    {
        return new Response;
    }
}
