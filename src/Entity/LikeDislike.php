<?php

namespace App\Entity;

use App\Repository\LikeDislikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikeDislikeRepository::class)]
class LikeDislike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'likeDislikes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Article1 $article = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'likeDislikes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User1 $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Article1
    {
        return $this->article;
    }

    public function setArticle(?Article1 $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?User1
    {
        return $this->user;
    }

    public function setUser(?User1 $user): static
    {
        $this->user = $user;

        return $this;
    }
}
