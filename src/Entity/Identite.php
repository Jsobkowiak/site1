<?php

namespace App\Entity;

use App\Repository\IdentiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IdentiteRepository::class)]
class Identite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $nom;

    #[ORM\Column(type: 'string', length: 30)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 30)]
    private $lieunaissance;

    #[ORM\Column(type: 'string', length: 100)]
    private $ville;

    #[ORM\Column(type: 'string', length: 100)]
    private $adresse;

    #[ORM\Column(type: 'integer')]
    private $codepostal;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\OneToOne(targetEntity: Fichier::class, cascade: ['persist', 'remove'])]
    private $anciennecard;

    #[ORM\OneToOne(targetEntity: Fichier::class, cascade: ['persist', 'remove'])]
    private $justifdomi;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'idDemande')]
    private $user;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $estvalide;

    #[ORM\Column(type: 'boolean')]
    private $sanscarte;

    #[ORM\OneToMany(mappedBy: 'identite', targetEntity: Notification::class)]
    private $notif;

    public function __construct()
    {
        $this->notif = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getLieunaissance(): ?string
    {
        return $this->lieunaissance;
    }

    public function setLieunaissance(string $lieunaissance): self
    {
        $this->lieunaissance = $lieunaissance;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAnciennecard(): ?Fichier
    {
        return $this->anciennecard;
    }

    public function setAnciennecard(?Fichier $anciennecard): self
    {
        $this->anciennecard = $anciennecard;

        return $this;
    }

    public function getJustifdomi(): ?Fichier
    {
        return $this->justifdomi;
    }

    public function setJustifdomi(?Fichier $justifdomi): self
    {
        $this->justifdomi = $justifdomi;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEstvalide(): ?int
    {
        return $this->estvalide;
    }

    public function setEstvalide(?int $estvalide): self
    {
        $this->estvalide = $estvalide;

        return $this;
    }

    public function getSanscarte(): ?bool
    {
        return $this->sanscarte;
    }

    public function setSanscarte(bool $sanscarte): self
    {
        $this->sanscarte = $sanscarte;

        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotif(): Collection
    {
        return $this->notif;
    }

    public function addNotif(Notification $notif): self
    {
        if (!$this->notif->contains($notif)) {
            $this->notif[] = $notif;
            $notif->setIdentite($this);
        }

        return $this;
    }

    public function removeNotif(Notification $notif): self
    {
        if ($this->notif->removeElement($notif)) {
            // set the owning side to null (unless already changed)
            if ($notif->getIdentite() === $this) {
                $notif->setIdentite(null);
            }
        }
        return $this;
    }
}
