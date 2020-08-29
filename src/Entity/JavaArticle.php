<?php

namespace App\Entity;

use App\Repository\JavaArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JavaArticleRepository::class)
 */
class JavaArticle
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
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $className;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $input;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $language = 'java';

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $output;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort_order;

    /**
     * @ORM\ManyToOne(targetEntity=JavaArticleCategory::class, inversedBy="javaArticles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDraggable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $referenceLink;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $codeSnippet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getClassName(): ?string
    {
        return $this->className;
    }

    public function setClassName(string $className): self
    {
        $this->className = $className;

        return $this;
    }

    public function getInput(): ?string
    {
        return $this->input;
    }

    public function setInput(?string $input): self
    {
        $this->input = $input;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getOutput(): ?string
    {
        return $this->output;
    }

    public function setOutput(?string $output): self
    {
        $this->output = $output;

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

    public function getCategory(): ?JavaArticleCategory
    {
        return $this->category;
    }

    public function setCategory(?JavaArticleCategory $category): self
    {
        $this->category = $category;

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

    public function getIsDraggable(): ?bool
    {
        return $this->isDraggable;
    }

    public function setIsDraggable(bool $isDraggable): self
    {
        $this->isDraggable = $isDraggable;

        return $this;
    }

    public function getReferenceLink(): ?string
    {
        return $this->referenceLink;
    }

    public function setReferenceLink(?string $referenceLink): self
    {
        $this->referenceLink = $referenceLink;

        return $this;
    }

    public function getCodeSnippet(): ?string
    {
        return $this->codeSnippet;
    }

    public function setCodeSnippet(?string $codeSnippet): self
    {
        $this->codeSnippet = $codeSnippet;

        return $this;
    }
}
