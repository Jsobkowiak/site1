<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Identite;
use App\Entity\User;
use App\Entity\Notification;
class GestionValideController extends AbstractController
{
    #[Route('/gestion-valide/{id}', name: 'gestion-valide', requirements: ["id"=>"\d+"] )]
    public function gestionvalide(int $id) {
        
                $doctrine = $this->getDoctrine()->getManager();        
                $identite = $doctrine->getRepository(Identite::class);
                $identites = $identite->find($id);
                
                $identites->setEstvalide(2);
                
                $doctrine->persist($identites);                        
                $user = null;
                $userid = $doctrine->getRepository(Identite::class)->findAll();
                foreach ($userid as $key) {
                    if($key->getId() == $id ){
                        $user = $key->getUser();
                    }
                }
                $notification = new Notification();
                $notification->setNom("Demande Validé");
                $notification->setMessage("Votre demande $id est validé");
                $notification->setUser($user);
                $notification->setIdentite($identites); 
                $doctrine->persist($notification);                        
                $doctrine->flush();
                return $this->redirectToRoute('administration'); 
                     
            }

            #[Route('/gestion-refuser/{id}', name: 'gestion-refuser', requirements: ["id"=>"\d+"] )]
            public function gestionrefuser(int $id) {
                
                $doctrine = $this->getDoctrine()->getManager();        
                $identite = $doctrine->getRepository(Identite::class);
                $identites = $identite->find($id);
                        
                        $identites->setEstvalide(1);
                        $user = null;
                        $userid = $doctrine->getRepository(Identite::class)->findAll();
                        foreach ($userid as $key) {
                            if($key->getId() == $id ){
                                $user = $key->getUser();
                            }
                        }
                        $notification = new Notification();
                        $notification->setNom("Demande Refusé");
                        $notification->setMessage("Votre demande $id est Refusé");
                        $notification->setUser($user);
                        $notification->setIdentite($identites); 
                        $doctrine->persist($notification);                        
                        $doctrine->flush();
                        $doctrine->persist($identites);                        
                        $doctrine->flush();            
                        
                        return $this->redirectToRoute('administration');
                    }

                    #[Route('/gestion-terminer/{id}', name: 'gestion-terminer', requirements: ["id"=>"\d+"] )]
                    public function gestionterminer(int $id) {
                        
                                $doctrine = $this->getDoctrine()->getManager();        
                                $identite = $doctrine->getRepository(Identite::class);
                                $identites = $identite->find($id);
                                $identites->setEstvalide(3);
                                
                                

                                $admin = [];
                                $user = $doctrine->getRepository(User::class);         
                                $users = $user->findAll();
                                foreach ($users as $user) {
                                    if(in_array("ROLE_ADMIN", $user->getRoles())){
                                        array_push($admin, $user);
                                    } 
                                
                                }
                                foreach ($admin as $administrateur) {
                                $notification = new Notification();
                                $notification->setNom("Demande Terminé");
                                $notification->setMessage("La demande $id est terminé");
                                $notification->setUser($administrateur);
                                $notification->setIdentite($identites); 
                                $doctrine->persist($notification);    

                                }
                                $doctrine->persist($identites);                        
                                $doctrine->flush();            
                                
                                return $this->redirectToRoute('profile');
                            }
        

}
