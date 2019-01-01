<?php

namespace App\Controller;

use App\Repository\LanguageRepository;
use App\Repository\SnippetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param SnippetRepository $snippetRepository
     * @param LanguageRepository $languageRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(SnippetRepository $snippetRepository, LanguageRepository $languageRepository)
    {
        $snippets = $snippetRepository->findLatest();
        $languages = $languageRepository->findLatest();

        return $this->render('home/index.html.twig', [
            'current_menu' => 'home',
            'snippets' => $snippets,
            'languages' => $languages
        ]);
    }
}
