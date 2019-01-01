<?php

namespace App\Controller;

use App\Entity\Language;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageController extends AbstractController
{
    /**
     * @Route("/languages/{slug}-{id}", name="languages.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Language $language
     * @param string $slug
     * @return Response
     */
    public function show(Language $language, string $slug): Response
    {
        if ($language->getSlug() !== $slug) {
            return $this->redirectToRoute('languages.show', [
                'id' => $language->getId(),
                'slug' => $language->getSlug()
            ], 301);
        }

        $snippets = $language->getSnippets();

        return $this->render('snippets/snippets-by-language-list.html.twig', [
            'snippets' => $snippets
        ]);
    }
}
