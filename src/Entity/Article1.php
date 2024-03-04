<?php

namespace App\Entity;

use App\Repository\Article1Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: Article1Repository::class)]
#[Vich\Uploadable]
class Article1
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $contenu = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated = null;

    #[ORM\OneToMany(mappedBy: 'idArticle', targetEntity: Comment1::class)]
    private Collection $comment1s;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: LikeDislike::class)]
    private Collection $likeDislikes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: 'article_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;


    public function __construct()
    {
        $this->comment1s = new ArrayCollection();
        $this->likeDislikes = new ArrayCollection();
    }

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): static
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
            $comment1->setIdArticle($this);
        }

        return $this;
    }

    public function removeComment1(Comment1 $comment1): static
    {
        if ($this->comment1s->removeElement($comment1)) {
            // set the owning side to null (unless already changed)
            if ($comment1->getIdArticle() === $this) {
                $comment1->setIdArticle(null);
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
            $likeDislike->setArticle($this);
        }

        return $this;
    }

    public function removeLikeDislike(LikeDislike $likeDislike): static
    {
        if ($this->likeDislikes->removeElement($likeDislike)) {
            // set the owning side to null (unless already changed)
            if ($likeDislike->getArticle() === $this) {
                $likeDislike->setArticle(null);
            }
        }

        return $this;
    }
    
    public function getImageName(): ?string
       
    {
           
    return $this->imageName;
       
    }
    
    
       
    public function setImageName(?string $imageName): self
       
    {
           
    $this->imageName=$imageName;
    return $this;
       
    }
    
    
       
    public function getImageFile():?File
       
    {
        return $this->imageFile;
       
    }
    
    
       
    public function setImageFile(?File $imageFile): void
       
    {
           
    $this->imageFile=$imageFile;       
    // Si l'image est définie, il est nécessaire de changer également la date de mise à jour pour que VichUploaderBundle fonctionne correctement.
           
    if($imageFile)
    {
         $this->updatedAt=new \DateTimeImmutable();
           
    }
       
    }






}
