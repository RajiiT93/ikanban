<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity]
#[ORM\Table(name: "utilisateur", uniqueConstraints: [
    new ORM\UniqueConstraint(name: "email_unique", columns: ["email"]),
    new ORM\UniqueConstraint(name: "nom_unique", columns: ["nom"])
])]
#[UniqueEntity(fields: ["nom"], message: "Ce nom d'utilisateur est déjà utilisé.")]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    #[Assert\Length(min: 5, max: 10, minMessage: "Oui, il faut minimum 5 caractères.", maxMessage: "Oui, il faut maximum 10 caractères.")]
    private ?string $nom = null;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $motDePasse = null;

    #[ORM\Column(type: "string", length: 20, nullable: true)]
    private ?string $roles = 'ROLE_USER';

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $service = null;

    #[ORM\ManyToMany(targetEntity: Groupe::class, inversedBy: "utilisateur")]
    #[ORM\JoinTable(name: "utilisateur_groupe")]
    private Collection $groupe;

    #[Assert\EqualTo(propertyPath: "motDePasse", message: "Les mots de passe ne correspondent pas.")]
    private ?string $verifMotDePasse = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Projet::class)]
    private Collection $projets;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Activite::class)]
    private Collection $activites;

    public function __construct()
    {
        $this->groupe = new ArrayCollection();
        $this->projets = new ArrayCollection();
        $this->activites = new ArrayCollection();
    }

    // 🔐 UserInterface + PasswordAuthenticatedUserInterface

    public function getUserIdentifier(): string
    {
        return $this->nom ?? '';
    }

    public function getPassword(): ?string
    {
        return $this->motDePasse;
    }

    public function getRoles(): array
    {
        $roles = [];

        if ($this->roles !== null) {
            $roles[] = $this->roles;
        }

        if (!in_array('ROLE_USER', $roles, true)) {
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    public function getRole(): ?string
    {
        return $this->roles ?? 'ROLE_USER';
    }

    public function eraseCredentials(): void
    {
        $this->verifMotDePasse = null;
    }

    // Getters & Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function setMotDePasse(?string $motDePasse): static
    {
        $this->motDePasse = $motDePasse;
        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setRoles(?string $roles): static
    {
        $this->roles = $roles ?? 'ROLE_USER';
        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;
        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(?string $service): static
    {
        $this->service = $service;
        return $this;
    }

    public function getGroupe(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Groupe $groupe): static
    {
        if (!$this->groupe->contains($groupe)) {
            $this->groupe[] = $groupe;
        }
        return $this;
    }

    public function removeGroupe(Groupe $groupe): static
    {
        $this->groupe->removeElement($groupe);
        return $this;
    }

    public function getVerifMotDePasse(): ?string
    {
        return $this->verifMotDePasse;
    }

    public function setVerifMotDePasse(?string $verifMotDePasse): static
    {
        $this->verifMotDePasse = $verifMotDePasse;
        return $this;
    }

    /**
     * @return Collection<int, Projet>
     */
    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): static
    {
        if (!$this->projets->contains($projet)) {
            $this->projets->add($projet);
            $projet->setUtilisateur($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): static
    {
        if ($this->projets->removeElement($projet)) {
            if ($projet->getUtilisateur() === $this) {
                $projet->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Activite>
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): static
    {
        if (!$this->activites->contains($activite)) {
            $this->activites->add($activite);
            $activite->setUtilisateur($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): static
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getUtilisateur() === $this) {
                $activite->setUtilisateur(null);
            }
        }

        return $this;
    }
}