<?php

namespace App\Controller\Admin;


use App\Entity\Language;
use App\Entity\Snippet;
use App\Form\LanguageType;
use App\Form\SnippetType;
use App\Repository\LanguageRepository;
use App\Repository\SnippetRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminSnippetsController extends AbstractController
{
    /**
     * @var SnippetRepository
     */
    private $snippetRepository;
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * AdminSnippetsController constructor.
     * @param SnippetRepository $snippetRepository
     * @param ObjectManager $em
     * @param LanguageRepository $languageRepository
     */
    public function __construct(
        SnippetRepository $snippetRepository,
        ObjectManager $em,
        LanguageRepository $languageRepository)
    {
        $this->snippetRepository = $snippetRepository;
        $this->em = $em;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @Route("/admin", name="admin.snippet.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $snippets = $this->snippetRepository->findAll();
        $languages = $this->languageRepository->findAll();

        return $this->render('admin/snippet/index.html.twig', [
            'snippets' => $snippets,
            'languages' => $languages
        ]);
    }

    /**
     * @Route("/admin/snippet/create", name="admin.snippet.create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $snippet = new Snippet();

        $formSnippet = $this->createForm(SnippetType::class, $snippet);
        $formSnippet->handleRequest($request);

        $language = new Language();
        $formLanguage = $this->createForm(LanguageType::class, $language);
        $formLanguage->handleRequest($request);

        if ($formSnippet->isSubmitted() && $formSnippet->isValid()) {
            $this->em->persist($snippet);
            $this->em->flush();
            $this->addFlash('success', 'Snippet crée avec succès');
            return $this->redirectToRoute('admin.snippet.index');
        }

        if ($formLanguage->isSubmitted() && $formLanguage->isValid()) {
            $this->em->persist($language);
            $this->em->flush();
            $this->addFlash('success', 'Language ajouté avec succès');
            return $this->redirectToRoute('admin.snippet.create');
        }

        return $this->render('admin/snippet/create.html.twig', [
            'form_snippet' => $formSnippet->createView(),
            'form_language' => $formLanguage->createView()
        ]);
    }

    /**
     * @Route("/admin/snippet/edit/{id}", name="admin.snippet.edit", methods={"GET|POST"})
     * @param Snippet $snippet
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Snippet $snippet, Request $request)
    {
        $form = $this->createForm(SnippetType::class, $snippet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Snippet modifié avec succès');
            return $this->redirectToRoute('admin.snippet.index');
        }

        return $this->render('admin/snippet/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/snippet/edit/{id}", name="admin.snippet.delete", methods={"DELETE"})
     * @param Snippet $snippet
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Snippet $snippet, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $snippet->getId(), $request->get('_token'))) {
            $this->em->remove($snippet);
            $this->em->flush();
            $this->addFlash('success', 'Snippet supprimé avec succès');
        }
        return $this->redirectToRoute('admin.snippet.index');
    }

}