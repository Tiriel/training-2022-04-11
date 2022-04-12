<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/author/admin")
 */
class AuthorAdminController extends AbstractController
{
    /**
     * @Route("/", name="app_author_admin_index", methods={"GET"})
     */
    public function index(AuthorRepository $authorRepository): Response
    {
        return $this->render('author_admin/index.html.twig', [
            'authors' => $authorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_author_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AuthorRepository $authorRepository): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $authorRepository->add($author);
            return $this->redirectToRoute('app_author_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('author_admin/new.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_author_admin_show", methods={"GET"})
     */
    public function show(Author $author): Response
    {
        return $this->render('author_admin/show.html.twig', [
            'author' => $author,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_author_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Author $author, AuthorRepository $authorRepository): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $authorRepository->add($author);
            return $this->redirectToRoute('app_author_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('author_admin/edit.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_author_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, Author $author, AuthorRepository $authorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
            $authorRepository->remove($author);
        }

        return $this->redirectToRoute('app_author_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
