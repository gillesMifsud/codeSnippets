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

class AdminLanguageController extends AbstractController
{
    /**
     * @var LanguageRepository
     */
    private $languageRepository;
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * AdminLanguageController constructor.
     * @param LanguageRepository $languageRepository
     * @param ObjectManager $em
     */
    public function __construct(LanguageRepository $languageRepository, ObjectManager $em)
    {
        $this->languageRepository = $languageRepository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/language/create", name="admin.language.create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $language = new Language();
        $formLanguage = $this->createForm(LanguageType::class, $language);
        $formLanguage->handleRequest($request);

        if ($formLanguage->isSubmitted() && $formLanguage->isValid()) {
            $this->em->persist($language);
            $this->em->flush();
            $this->addFlash('success', 'Language ajouté avec succès');
            return $this->redirectToRoute('admin.snippet.index');
        }

        return $this->render('admin/language/create.html.twig', [
            'form_language' => $formLanguage->createView()
        ]);
    }

    /**
     * @Route("/admin/language/edit/{id}", name="admin.language.edit", methods={"GET|POST"})
     * @param Language $language
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(Language $language, Request $request)
    {
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Language modifié avec succès');
            return $this->redirectToRoute('admin.snippet.index');
        }

        return $this->render('admin/language/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/language/edit/{id}", name="admin.language.delete", methods={"DELETE"})
     * @param Language $language
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Language $language, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $language->getId(), $request->get('_token'))) {
            $this->em->remove($language);
            $this->em->flush();
            $this->addFlash('success', 'Language supprimé avec succès');
        }
        return $this->redirectToRoute('admin.snippet.index');
    }

}