<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeDocumentRepository")
 * @UniqueEntity("type")
 */
class TypeDocument
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
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SousTypeDocument", mappedBy="type")
     */
    private $sousTypeDocument;

    public function __construct()
    {
        $this->sousTypeDocument = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|SousTypeDocument[]
     */
    public function getSousTypeDocument(): Collection
    {
        return $this->sousTypeDocument;
    }

    public function addSousTypeDocument(SousTypeDocument $sousTypeDocument): self
    {
        if (!$this->sousTypeDocument->contains($sousTypeDocument)) {
            $this->sousTypeDocument[] = $sousTypeDocument;
            $sousTypeDocument->setType($this);
        }

        return $this;
    }

    public function removeSousTypeDocument(SousTypeDocument $sousTypeDocument): self
    {
        if ($this->sousTypeDocument->contains($sousTypeDocument)) {
            $this->sousTypeDocument->removeElement($sousTypeDocument);
            // set the owning side to null (unless already changed)
            if ($sousTypeDocument->getType() === $this) {
                $sousTypeDocument->setType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->type;
    }
}
