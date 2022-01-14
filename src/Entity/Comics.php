<?php

namespace App\Entity;

use App\Repository\ComicsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComicsRepository::class)
 */
class Comics
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $year;

    /**
     * @ORM\OneToOne(targetEntity=Designer::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $designer;

    /**
     * @ORM\OneToOne(targetEntity=Editor::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $editor;

    /**
     * @ORM\OneToOne(targetEntity=Licence::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $licence;

    /**
     * @ORM\OneToOne(targetEntity=Writer::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $writer;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="comics", orphanRemoval=true)
     */
    private $image;

    public function __construct()
    {
        $this->image = new ArrayCollection();
    }



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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(\DateTimeInterface $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getDesigner(): ?Designer
    {
        return $this->designer;
    }

    public function setDesigner(Designer $designer): self
    {
        $this->designer = $designer;

        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(Editor $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getLicence(): ?Licence
    {
        return $this->licence;
    }

    public function setLicence(Licence $licence): self
    {
        $this->licence = $licence;

        return $this;
    }

    public function getWriter(): ?Writer
    {
        return $this->writer;
    }

    public function setWriter(Writer $writer): self
    {
        $this->writer = $writer;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setComics($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getComics() === $this) {
                $image->setComics(null);
            }
        }

        return $this;
    }
}