<?php

namespace App\Entity;

use App\Repository\User1Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: User1Repository::class)]
class User1
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'idUser1', targetEntity: Comment1::class)]
    private Collection $comment1s;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: LikeDislike::class)]
    private Collection $likeDislikes;

   

    public function __construct()
    {
        $this->comment1s = new ArrayCollection();
        $this->likeDislikes = new ArrayCollection();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }
    
    public function __toString()
    {
        return $this->id;
    }


    /**
     * @return Collection<int, Comment1>
     */
    public function getComment1s(): Collection
    {
        return $this->comment1s;
    }

    public function addComment1(Comment1 $comment1): static
    {
        if (!$this->comment1s->contains($comment1)) {
            $this->comment1s->add($comment1);
            $comment1->setIdUser1($this);
        }

        return $this;
    }

    public function removeComment1(Comment1 $comment1): static
    {
        if ($this->comment1s->removeElement($comment1)) {
            // set the owning side to null (unless already changed)
            if ($comment1->getIdUser1() === $this) {
                $comment1->setIdUser1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LikeDislike>
     */
    public function getLikeDislikes(): Collection
    {
        return $this->likeDislikes;
    }

    public function addLikeDislike(LikeDislike $likeDislike): static
    {
        if (!$this->likeDislikes->contains($likeDislike)) {
            $this->likeDislikes->add($likeDislike);
            $likeDislike->setUser($this);
        }

        return $this;
    }

    public function removeLikeDislike(LikeDislike $likeDislike): static
    {
        if ($this->likeDislikes->removeElement($likeDislike)) {
            // set the owning side to null (unless already changed)
            if ($likeDislike->getUser() === $this) {
                $likeDislike->setUser(null);
            }
        }

        return $this;
    }

   

   
}
