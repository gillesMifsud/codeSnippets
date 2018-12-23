<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SnippetsController extends AbstractController
{
    /**
     * @Route("/snippets", name="snippets.index")
     */
    public function index()
    {
        return $this->render('snippets/index.html.twig', [
            'controller_name' => 'SnippetsController',
            'current_menu' => 'snippets'
        ]);
    }
}
