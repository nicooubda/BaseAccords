<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SousTypeDocumentRepository")
 * @UniqueEntity("sousType")
 */
class SousTypeDocument
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
    private $sousType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeDocument", inversedBy="sousTypeDocument")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Accords", mappedBy="sousTypeDocument")
     */
    private $accord;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSousType(): ?string
    {
        return $this->sousType;
    }

    public function setSousType(string $sousType): self
    {
        $this->sousType = $sousType;

        return $this;
    }

    public function getType(): ?TypeDocument
    {
        return $this->type;
    }

    public function setType(?TypeDocument $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Accords[]
     */
    public function getAccord(): Collection
    {
        return $this->accord;
    }

    /**
     * @return Collection|SousTypeDocument[]
     */
    public function getSousTypeDocument(): Collection
    {
        return $this->sousTypeDocument;
    }

    public function addAccord(Accords $accord): self
    {
        if (!$this->accord->contains($accord)) {
            $this->accord[] = $accord;
            $accord->setSousTypeDocument($this);
        }

        return $this;
    }

    public function removeAccords(Accords $accord): self
    {
        if ($this->accord->contains($accord)) {
            $this->accord->removeElement($accord);
            // set the owning side to null (unless already changed)
            if ($accord->getSousTypeDocument() === $this) {
                $accord->setSousTypeDocument(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->sousType;
    }
}
