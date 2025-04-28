<?php

namespace App\Entity;

use App\Entity\Projet;
use App\Entity\Utilisateur;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Invitation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    // L'utilisateur invité dans ce projet
    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    // Le projet dans lequel l'utilisateur est invité
    #[ORM\ManyToOne(targetEntity: Projet::class, inversedBy: 'invitations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projet $projet = null;

    // Autres propriétés comme le statut de l'invitation, date d'invitation, etc.
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $dateInvitation = null;

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;
        return $this;
    }

    public function getDateInvitation(): ?\DateTimeInterface
    {
        return $this->dateInvitation;
    }

    public function setDateInvitation(?\DateTimeInterface $dateInvitation): self
    {
        $this->dateInvitation = $dateInvitation;
        return $this;
    }
}
