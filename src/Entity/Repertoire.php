<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RepertoireRepository")
 */
class Repertoire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=700)
     */
    private $repertoire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Langue", inversedBy="repertoire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $langue;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Accords", inversedBy="repertoire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $accord;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepertoire(): ?string
    {
        return $this->repertoire;
    }

    public function setRepertoire(string $repertoire): self
    {
        $this->repertoire = $repertoire;

        return $this;
    }

    public function getLangue(): ?Langue
    {
        return $this->langue;
    }

    public function setLangue(?Langue $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getAccord(): ?Accords
    {
        return $this->accord;
    }

    public function setAccord(?Accords $accord): self
    {
        $this->accord = $accord;

        return $this;
    }

    public function __toString()
    {
        return $this->repertoire;
    }
}
