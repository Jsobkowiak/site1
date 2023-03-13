<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FichierController extends AbstractController
{
    #[Route('/ajout-identite', name: 'ajout-identite')]
    public function addidentite(): Response
    {
        return $this->render('base/ajout-identite.html.twig', [
        ]);
    }
}
