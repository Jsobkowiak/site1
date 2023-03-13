<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionDemandeController extends AbstractController
{
    #[Route('/gestiondemande', name: 'gestion_demande')]
    public function index(): Response
    {
        
        return $this->render('gestion_demande/index.html.twig', [

        ]);
    }
}
