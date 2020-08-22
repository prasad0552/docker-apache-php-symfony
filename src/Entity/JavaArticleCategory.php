<?php

namespace App\Entity;

use App\Repository\JavaArticleCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JavaArticleCategoryRepository::class)
 */
class JavaArticleCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort_order;

    /**
     * @ORM\OneToMany(targetEntity=JavaArticle::class, mappedBy="category")
     */
    private $javaArticles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    public function __construct()
    {
        $this->javaArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getSortOrder(): ?int
    {
        return $this->sort_order;
    }

    public function setSortOrder(int $sort_order): self
    {
        $this->sort_order = $sort_order;

        return $this;
    }

    /**
     * @return Collection|JavaArticle[]
     */
    public function getJavaArticles(): Collection
    {
        return $this->javaArticles;
    }

    public function addJavaArticle(JavaArticle $javaArticle): self
    {
        if (!$this->javaArticles->contains($javaArticle)) {
            $this->javaArticles[] = $javaArticle;
            $javaArticle->setCategory($this);
        }

        return $this;
    }

    public function removeJavaArticle(JavaArticle $javaArticle): self
    {
        if ($this->javaArticles->contains($javaArticle)) {
            $this->javaArticles->removeElement($javaArticle);
            // set the owning side to null (unless already changed)
            if ($javaArticle->getCategory() === $this) {
                $javaArticle->setCategory(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
