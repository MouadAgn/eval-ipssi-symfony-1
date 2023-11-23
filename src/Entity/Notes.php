<?php

namespace App\Entity;

use App\Repository\NotesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotesRepository::class)]
class Notes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $note = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dates = null;

    #[ORM\Column(length: 255)]
    private ?string $matieres = null;

    #[ORM\ManyToOne(inversedBy: 'notes')]
    private ?Matieres $matiere = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getDates(): ?\DateTimeImmutable
    {
        return $this->dates;
    }

    public function setDates(\DateTimeImmutable $dates): static
    {
        $this->dates = $dates;

        return $this;
    }

    public function getMatieres(): ?string
    {
        return $this->matieres;
    }

    public function setMatieres(string $matieres): static
    {
        $this->matieres = $matieres;

        return $this;
    }

    public function getMatiere(): ?Matieres
    {
        return $this->matiere;
    }

    public function setMatiere(?Matieres $matiere): static
    {
        $this->matiere = $matiere;

        return $this;
    }
}
