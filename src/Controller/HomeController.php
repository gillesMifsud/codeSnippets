<?php

namespace App\Controller;

use App\Repository\SnippetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param SnippetRepository $snippetRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(SnippetRepository $snippetRepository)
    {
        $snippets = $snippetRepository->findLatest();

        return $this->render('home/index.html.twig', [
            'current_menu' => 'home',
            'snippets' => $snippets
        ]);
    }
}
