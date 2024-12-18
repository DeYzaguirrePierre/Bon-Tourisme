<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LieuRepository::class)]
class Lieu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?float $moy_avis = 0.0;

    #[ORM\Column(nullable: true)]
    private ?int $nb_avis = 0;


    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'lieu', orphanRemoval: true)]
    private Collection $avis;

    #[ORM\ManyToMany(targetEntity: TypeLieu::class, inversedBy: 'lieux')]
    private Collection $typeLieux;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
        $this->typeLieux = new ArrayCollection(); // Initialisation de la relation
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMoyAvis(): ?float
    {
        return $this->moy_avis;
    }

    public function setMoyAvis(float $moy_avis): static
    {
        $this->moy_avis = $moy_avis;

        return $this;
    }

    public function getNbAvis(): ?int
    {
        return $this->nb_avis;
    }

    public function setNbAvis(int $nb_avis): static
    {
        $this->nb_avis = $nb_avis;

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setLieu($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            if ($avi->getLieu() === $this) {
                $avi->setLieu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TypeLieu>
     */
    public function getTypeLieux(): Collection
    {
        return $this->typeLieux;
    }

    public function addTypeLieux(TypeLieu $typeLieu): static
    {
        if (!$this->typeLieux->contains($typeLieu)) {
            $this->typeLieux->add($typeLieu);
        }

        return $this;
    }

    public function removeTypeLieux(TypeLieu $typeLieu): static
    {
        $this->typeLieux->removeElement($typeLieu);

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom ?? 'Lieu';
    }
}
