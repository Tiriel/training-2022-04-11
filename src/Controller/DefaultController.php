<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_default_index")
     */
    public function index(MovieRepository $repository): Response
    {
        $movies = $repository->findNewest(6);

        return $this->render('default/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("/contact", name="app_default_contact")
     */
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class, []);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
        }

        return $this->renderForm('default/contact.html.twig', [
            'form' => $form
        ]);
    }

    public function menu()
    {
        return '';
    }
}
