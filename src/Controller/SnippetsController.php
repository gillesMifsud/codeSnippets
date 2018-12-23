<?php

namespace App\Controller;

use App\Entity\Language;
use App\Entity\Snippet;
use App\Repository\SnippetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SnippetsController extends AbstractController
{
    /**
     * @var SnippetRepository
     */
    private $snippetRepository;

    /**
     * SnippetsController constructor.
     * @param SnippetRepository $snippetRepository
     */
    public function __construct(SnippetRepository $snippetRepository)
    {
        $this->snippetRepository = $snippetRepository;
    }

    /**
     * @Route("/snippets", name="snippets.index")
     */
    public function index(): Response
    {
        $snippets = $this->snippetRepository->findAll();

        return $this->render('snippets/index.html.twig', [
            'current_menu' => 'snippets',
            'snippets' => $snippets
        ]);
    }

    /**
     * @Route("/snippets/{slug}-{id}", name="snippet.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Snippet $snippet
     * @param string $slug
     * @return Response
     */
    public function show(Snippet $snippet, string $slug): Response
    {
        if ($snippet->getSlug() !== $slug) {
            return $this->redirectToRoute('snippet.show', [
                'id' => $snippet->getId(),
                'slug' => $snippet->getSlug()
            ], 301);
        }
        return $this->render('snippets/show.html.twig', [
            'current_menu' => 'snippets',
            'snippet' => $snippet
        ]);
    }
}
