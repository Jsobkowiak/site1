<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Notification;

class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'notification')]
    public function index(): Response
    {
        $listeNotif = $this->getDoctrine()->getRepository(Notification::class);
        $listenotification = $listeNotif->findAll();
        return $this->render('notification/index.html.twig', [
            'listenotif' => $listenotification
        ]);
    }

    #[Route('/notification-delete/{id}', name: 'notification-delete', requirements: ["id"=>"\d+"] )]
    public function gestionvalide(int $id) {
        
                $doctrine = $this->getDoctrine()->getManager();        
                $notification = $doctrine->getRepository(Notification::class);
                $notifications = $notification->find($id);
                
                $doctrine->Remove($notifications);
                $doctrine->flush();    
            
                return $this->redirectToRoute('index'); 
                     
            }
}
