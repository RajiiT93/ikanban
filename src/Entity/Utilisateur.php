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
    #[Assert\Length(
        min: 5,
        max: 10,
        minMessage: "Oui, il faut minimum 5 caractères.",
        maxMessage: "Oui, il faut maximum 10 caractères."
    )]
    private ?string $nom = null;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Assert\Length(
        min: 5,
        max: 10,
        minMessage: "Oui, il faut minimum 5 caractères.",
        maxMessage: "Oui, il faut maximum 10 caractères."
    )]
    private ?string $motDePasse = null;

    #[ORM\Column(type: "string", length: 20, nullable: true)]
    private ?string $role = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $service = null;

    #[ORM\ManyToMany(targetEntity: "App\Entity\Groupe", inversedBy: "utilisateur")]
    #[ORM\JoinTable(name: "utilisateur_groupe")]
    private Collection $groupe;

    #[Assert\EqualTo(
        propertyPath: "motDePasse",
        message: "Les mots de passe ne correspondent pas."
    )]
    private ?string $verifMotDePasse = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Projet::class)]
    private Collection $projets;

    public function __construct()
    {
        $this->groupe = new ArrayCollection();
        $this->projets = new ArrayCollection();
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

        if ($this->role) {
            $roles[] = $this->role;
        }

        // Toujours garantir ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
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

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setMotDePasse(?string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;
        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;
        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(?string $service): self
    {
        $this->service = $service;
        return $this;
    }

    public function getGroupe(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupe->contains($groupe)) {
            $this->groupe[] = $groupe;
        }
        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        $this->groupe->removeElement($groupe);
        return $this;
    }

    public function getVerifMotDePasse(): ?string
    {
        return $this->verifMotDePasse;
    }

    public function setVerifMotDePasse(?string $verifMotDePasse): self
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
            // set the owning side to null (unless already changed)
            if ($projet->getUtilisateur() === $this) {
                $projet->setUtilisateur(null);
            }
        }

        return $this;
    }
}
