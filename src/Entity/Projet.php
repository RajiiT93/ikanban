<?php

namespace App\Entity;

use App\Entity\Utilisateur;
use App\Entity\Tache;
use App\Entity\Invitation; // Assurez-vous d'importer l'entité Invitation
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $deadline = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'projets')]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class)]
    private Collection $membres;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: Tache::class, orphanRemoval: true)]
    private Collection $taches;

    // Relation OneToMany avec l'entité 'Invitation'
    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: Invitation::class, orphanRemoval: true)]
    private Collection $invitations;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->taches = new ArrayCollection();
        $this->invitations = new ArrayCollection();  // Initialisation de la collection d'invitations
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Utilisateur $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres[] = $membre;
        }
        return $this;
    }

    public function removeMembre(Utilisateur $membre): self
    {
        $this->membres->removeElement($membre);
        return $this;
    }

    /**
     * @return Collection|Tache[]
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTache(Tache $tache): self
    {
        if (!$this->taches->contains($tache)) {
            $this->taches[] = $tache;
            $tache->setProjet($this);
        }
        return $this;
    }

    public function removeTache(Tache $tache): self
    {
        if ($this->taches->removeElement($tache)) {
            if ($tache->getProjet() === $this) {
                $tache->setProjet(null);
            }
        }
        return $this;
    }

    // Méthodes pour gérer les invitations

    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(Invitation $invitation): self
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations[] = $invitation;
            $invitation->setProjet($this);
        }
        return $this;
    }

    public function removeInvitation(Invitation $invitation): self
    {
        if ($this->invitations->removeElement($invitation)) {
            if ($invitation->getProjet() === $this) {
                $invitation->setProjet(null);
            }
        }
        return $this;
    }
}
