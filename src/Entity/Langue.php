<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LangueRepository")
 * @UniqueEntity("langue")
 */
class Langue
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
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $abreviation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Repertoire",mappedBy="langue")
     */
    private $repertoire;

    public function __construct()
    {
        $this->repertoire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getAbreviation(): ?string
    {
        return $this->abreviation;
    }

    public function setAbreviation(string $abreviation): self
    {
        $this->abreviation = $abreviation;

        return $this;
    }

    /**
     * @return Collection|Repertoire[]
     */
    public function getRepertoire(): Collection
    {
        return $this->repertoire;
    }

    public function addRepertoire(Repertoire $repertoire): self
    {
        if (!$this->repertoire->contains($repertoire)) {
            $this->repertoire[] = $repertoire;
            $repertoire->setLangue($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoire->contains($repertoire)) {
            $this->repertoire->removeElement($repertoire);
            // set the owning side to null (unless already changed)
            if ($repertoire->getLangue() === $this) {
                $repertoire->setLangue(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->langue;
    }
}
