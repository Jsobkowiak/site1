<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Entity\Contact;
use App\Form\AvisType;
use App\Entity\Avis;
use App\Form\IdentiteType;
use App\Entity\Identite;
use App\Form\GestionType;
use App\Entity\Gestion;
use App\Entity\User;
use App\Form\NewPasswordType;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Fichier;
use App\Entity\Notification;

class BaseController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(Request $request): Response
    {
        $repoAvis = $this->getDoctrine()->getRepository(Avis::class);
        $lesavis = $repoAvis->findAll();
        
        $avis = new Avis();
        $form = $this->createForm(AvisType::class);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted()&&$form->isValid()){
                $nom = $form['nom']->getData();
                $commentaire = $form['message']->getData();
                $email = $form['email']->getData();
                $note = $form['note']->getData();
                

                $avis->setDate(new \DateTime());
                $avis->setNote($note);
                $avis->setNom($nom);
                $avis->setMessage($commentaire);
                $avis->setEmail($email);


                $em = $this->getDoctrine()->getManager();
                $em->persist($avis);
                $em->flush();
                
                $this->addFlash('notice','Votre avis a bien était  envoyé');
                return $this->redirectToRoute('index');
            }
        }
    
        return $this->render('base/index.html.twig', [
            'form' => $form->createView(),
            'lesavis' => $lesavis
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        
        $contact = new Contact();
        
        $form = $this->createForm(ContactType::class, $contact);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $email = (new TemplatedEmail())
                ->from($form->get('email')->getData())
                ->to('jonathan.sobkowiak62@gmail.com')
                ->subject($form->get('sujet')->getData())
                ->htmlTemplate('emails/email.html.twig')
                ->context([
                    'nom'=> $form->get('nom')->getData(),
                    'sujet'=> $form->get('sujet')->getData(),
                    'message'=> $form->get('message')->getData()
                ]);
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();
                
                $mailer->send($email);

                $this->addFlash('notice','Votre Message a bien était  envoyé');
                return $this->redirectToRoute('contact');
            }
        }
        return $this->render('base/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/identite', name: 'identite')]
    public function carteidentite(Request $request,  SluggerInterface $slugger): Response
    {   
        $identite = new Identite();
        $form = $this->createForm(identiteType::class);
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
                    $identite->setJustifdomi($f);
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

                        $identite->setAnciennecard($f);

                        $fichier2->move($this->getParameter('file_directory'), $nomFichier);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($f);                        
                        $em->flush(); 
                    }
                    catch(FileException $e){ 
    
                         $this->addFlash('notice', 'Erreur d\'envoi');
                        }
                    }






                $nom = $form['nom']->getData();
                $prenom = $form['prenom']->getData();
                $lieunaissance = $form['lieunaissance']->getData();
                $ville = $form['Ville']->getData();
                $adresse = $form['Adresse']->getData();
                $codepostal = $form['codepostal']->getData();
                $date = $form['date']->getData();
                $sanscart = $form['sanscarte']->getData();

                $identite->setNom($nom);
                $identite->setPrenom($prenom);
                $identite->setLieunaissance($lieunaissance);
                $identite->setVille($ville);
                $identite->setAdresse($adresse);
                $identite->setCodepostal($codepostal);
                $identite->setDate($date);
                $identite->setSanscarte($sanscart);

   


                $admin = [];
                $user = $em->getRepository(User::class);         
                $users = $user->findAll();
                
                
               
                foreach ($users as $user) {
                if(in_array("ROLE_ADMIN", $user->getRoles())){
                    array_push($admin, $user);
                } 
 
                }
                foreach ($admin as $administrateur) {
                $notification = new Notification();
                $notification->setNom("Demande Identité");
                $notification->setMessage("Vous avez une nouvelle demande d'identité");
                $notification->setUser($administrateur);
                $notification->setIdentite($identite);                
                 $em->persist($notification);

                }
                


                $identite->setUser($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($identite);
                $em->flush();
                

                $this->addFlash('notice','Votre demande a bien était  envoyé');
                return $this->redirectToRoute('identite');
            }
        }
        return $this->render('base/identite.html.twig', [
            'form' => $form->createView()
        ]);
    }
    

    #[Route('/gestion', name: 'gestion')]
    public function gestion(Request $request): Response
    {
        $form = $this->createForm(GestionType::class);
        $gestion = new Gestion();
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted()&&$form->isValid()){
                $nom = $form['nom']->getData();
                $prenom = $form['prenom']->getData();
                $date = $form['date']->getData();
                $email = $form['email']->getData();
                $ecole = $form['ecole']->getData();

                $gestion->setEcole($ecole);
                $gestion->setEmail($email);
                $gestion->setNom($nom);
                $gestion->setPrenom($prenom);
                $gestion->setDate($date);


                $em = $this->getDoctrine()->getManager();
                $em->persist($gestion);
                $em->flush();

                $this->addFlash('notice','Votre demande a bien était  envoyé');
                return $this->redirectToRoute('gestion');
            }
        }
        return $this->render('base/gestion.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/administration', name: 'administration')]
    public function administratino(): Response
    {
        $listeIdentite = $this->getDoctrine()->getRepository(Identite::class);
        $listeiden = $listeIdentite->findAll();

        $listegestion = $this->getDoctrine()->getRepository(Gestion::class);
        $listegest = $listegestion->findAll();
        return $this->render('base/administration.html.twig', [
            'listegestion' => $listegest,
            'listeiden' => $listeiden
        ]);
    }


    #[Route('/presentation', name: 'presentation')]
    public function presentation(): Response
    {

        return $this->render('base/presentation.html.twig', [

        ]);
    }




    #[Route('/profile', name: 'profile')]
    public function profile(Request $request): Response
    {
        $listeIdentite = $this->getDoctrine()->getRepository(Identite::class);
        $listeiden = $listeIdentite->findAll();
        return $this->render('base/profile.html.twig', [
            'listeiden' => $listeiden
        ]);
    }

    #[Route('/profil-telechargement-fichier/{id}', name: 'telechargement-fichier', requirements: ["id"=>"\d+"] )]
    public function telechargementFichier(int $id) {
                $doctrine = $this->getDoctrine();        
                $repoFichier = $doctrine->getRepository(Fichier::class);         
                $fichier = $repoFichier->find($id);        
                if ($fichier == null){
                    return $this->redirectToRoute('ajout_fichier'); 
                }else{            
                    return $this->file($this->getParameter('file_directory').'/'.$fichier->getNomServeur(), $fichier->getNomOriginal());        
                }     
            }
    

            #[Route('/adminidentite', name: 'adminidentite')]
            public function adminidentite(): Response
            {
                $listeIdentite = $this->getDoctrine()->getRepository(Identite::class);
                $listeiden = $listeIdentite->findAll();
        

                return $this->render('base/adminidentite.html.twig', [

                    'listeiden' => $listeiden
                ]);
            }

            
}
