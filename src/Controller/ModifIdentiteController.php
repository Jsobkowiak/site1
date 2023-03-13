<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Identite;
use App\Form\IdentiteType;
use App\Entity\User;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Fichier;

class ModifIdentiteController extends AbstractController
{

    #[Route('/gestion-modif/{id}', name: 'gestion-modif', requirements: ["id"=>"\d+"] )]
    public function gestionmodif(int $id, Request $request, SluggerInterface $slugger){
                 $doctrine = $this->getDoctrine()->getManager();  
                 $modifidentite = $doctrine->getRepository(Identite::class);
                 $demande = $modifidentite->find($id);
                 $form = $this->createForm(IdentiteType::class, $demande);
                //dump($demande);

                if($request->isMethod('POST')){
                    $form->handleRequest($request);
                    if($form->isSubmitted()&&$form->isValid()){
                        $fichier = $form->get('fichier')->getData();
                        if($fichier){
                        $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                        $nomFichier = $slugger->slug($nomFichier);
                        $nomFichier = $nomFichier.'-'.uniqid().'.'.$fichier->guessExtension();
                        try{
                            $f = new Fichier();                 
                            $f->setNomServeur($nomFichier);                        
                            $f->setNomOriginal($fichier->getClientOriginalName());                                          
                            $f->setExtension($fichier->guessExtension());                        
                            $f->setTaille($fichier->getSize());                        
                            $f->setProprietaire($this->getUser());
                            $demande->setJustifdomi($f);
                            $fichier->move($this->getParameter('file_directory'), $nomFichier);
                            $em = $this->getDoctrine()->getManager();
                            $em->persist($f);                        
                            $em->flush(); 
                        }
                        catch(FileException $e){ 
        
                             $this->addFlash('notice', 'Erreur d\'envoi');
                            }
                        }
                        $fichier2 = $form->get('fichier2')->getData();
                        if($fichier2){
                            $nomFichier = pathinfo($fichier2->getClientOriginalName(), PATHINFO_FILENAME);
                            $nomFichier = $slugger->slug($nomFichier);
                            $nomFichier = $nomFichier.'-'.uniqid().'.'.$fichier2->guessExtension();
                            try{
                                $f = new Fichier();                 
                                $f->setNomServeur($nomFichier);                        
                                $f->setNomOriginal($fichier2->getClientOriginalName());                                          
                                $f->setExtension($fichier2->guessExtension());                        
                                $f->setTaille($fichier2->getSize());                        
                                $f->setProprietaire($this->getUser());
        
                                $demande->setAnciennecard($f);
        
                                $fichier2->move($this->getParameter('file_directory'), $nomFichier);
                                $em = $this->getDoctrine()->getManager();
                                $em->persist($f);                        
                                $em->flush(); 
                                
                            }
                            catch(FileException $e){ 
            
                                 $this->addFlash('notice', 'Erreur d\'envoi');
                                }
                            }

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($demande);
                        $em->flush();
                    }
                    $this->addFlash('notice', 'Modification Réussi');
                    return $this->redirectToRoute('profile');

                }
                
                return $this->render('modif_identite/index.html.twig', [
                    'form' => $form->createView()
                ]);
            }
}
