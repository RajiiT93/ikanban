<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActiviteRepository::class)]
class Activite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeAction = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $dateAction = null;

    // Utilisateur qui a effectué l'action
    #[ORM\ManyToOne(inversedBy: 'activites')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Utilisateur $utilisateur = null;

    // Projet lié à l'activité (ex: création projet, suppression, ajout de tache dans un projet)
    #[ORM\ManyToOne(inversedBy: 'activites')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Projet $projet = null;

    // Tâche liée à l'activité (ex: création tâche, modification, suppression)
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Tache $tache = null;

    // -------------------- Getters & Setters -------------------- //

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeAction(): ?string
    {
        return $this->typeAction;
    }

    public function setTypeAction(string $typeAction): static
    {
        $this->typeAction = $typeAction;
        return $this;
    }

    public function getDateAction(): ?\DateTimeImmutable
    {
        return $this->dateAction;
    }

    public function setDateAction(\DateTimeImmutable $dateAction): static
    {
        $this->dateAction = $dateAction;
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): static
    {
        $this->projet = $projet;
        return $this;
    }

    public function getTache(): ?Tache
    {
        return $this->tache;
    }

    public function setTache(?Tache $tache): static
    {
        $this->tache = $tache;
        return $this;
    }
}
