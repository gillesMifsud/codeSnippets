<?php

namespace App\Controller;

use App\Entity\Language;
use App\Entity\Snippet;
use App\Repository\SnippetRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $query = $this->snippetRepository->findAllPaginateQuery();

        $snippets = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/  );

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
