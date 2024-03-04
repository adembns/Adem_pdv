<?php

namespace App\Entity;

use App\Repository\Comment1Repository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Comment1Repository::class)]
class Comment1
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated = null;

 

    #[ORM\ManyToOne(inversedBy: 'comment1s')]
    private ?Article1 $idArticle = null;

    #[ORM\ManyToOne(inversedBy: 'comment1s',cascade: ['persist'])]
    private ?User1 $idUser1 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): static
    {
        $this->updated = $updated;

        return $this;
    }

   

    public function getIdArticle(): ?Article1
    {
        return $this->idArticle;
    }

    public function setIdArticle(?Article1 $idArticle): static
    {
        $this->idArticle = $idArticle;

        return $this;
    }

    public function getIdUser1(): ?User1
    {
        return $this->idUser1;
    }

    public function setIdUser1(?User1 $idUser1): static
    {
        $this->idUser1 = $idUser1;

        return $this;
    }
}
