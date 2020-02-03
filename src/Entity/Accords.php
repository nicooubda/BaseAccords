<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccordsRepository")
 */
class Accords
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
    private $cote;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $boiteArchive;

    /**
     * @ORM\Column(type="date")
     */
    private $dateSignature_at;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEntree_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieuSignature;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etatAccord;

    /**
     * @ORM\Column(type="text")
     */
    private $intitule;

    /**
     * @ORM\Column(type="text")
     */
    private $motCle;

    /**
     * @ORM\Column(type="text")
     */
    private $motGeo;

    /**
     * @ORM\Column(type="text")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SousTypeDocument",inversedBy="accord")
     */
    private $sousTypeDocument;

    /**
     * @ORM\Column(type="text")
     */
    private $resume;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Repertoire",mappedBy="accord")
     */
    private $repertoire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User",inversedBy="accords")
     */
    private $users;

    public function __construct()
    {
        $this->repertoire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCote(): ?string
    {
        return $this->cote;
    }

    public function setCote(string $cote): self
    {
        $this->cote = $cote;

        return $this;
    }

    public function getBoiteArchive(): ?string
    {
        return $this->boiteArchive;
    }

    public function setBoiteArchive(string $boiteArchive): self
    {
        $this->boiteArchive = $boiteArchive;

        return $this;
    }

    public function getDateSignatureAt(): ?\DateTimeInterface
    {
        return $this->dateSignature_at;
    }

    public function setDateSignatureAt($dateSignature_at): self
    {
        $this->dateSignature_at = $dateSignature_at;

        return $this;
    }

    public function getDateEntreeAt(): ?\DateTimeInterface
    {
        return $this->dateEntree_at;
    }

    public function setDateEntreeAt($dateEntree_at): self
    {
        $this->dateEntree_at = $dateEntree_at;

        return $this;
    }

    public function getLieuSignature(): ?string
    {
        return $this->lieuSignature;
    }

    public function setLieuSignature(string $lieuSignature): self
    {
        $this->lieuSignature = $lieuSignature;

        return $this;
    }

    public function getEtatAccord(): ?string
    {
        return $this->etatAccord;
    }

    public function setEtatAccord(string $etatAccord): self
    {
        $this->etatAccord = $etatAccord;

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getMotCle(): ?string
    {
        return $this->motCle;
    }

    public function setMotCle(string $motCle): self
    {
        $this->motCle = $motCle;

        return $this;
    }

    public function getMotGeo(): ?string
    {
        return $this->motGeo;
    }

    public function setMotGeo(string $motGeo): self
    {
        $this->motGeo = $motGeo;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * @return Collection|Repertoire[]
     */
    public function getRepertoire(): Collection
    {
        return $this->repertoire;
    }

    public function getSousTypeDocument(): ?SousTypeDocument
    {
        return $this->sousTypeDocument;
    }

    public function setSousTypeDocument(?SousTypeDocument $sousTypeDocument): self
    {
        $this->sousTypeDocument = $sousTypeDocument;

        return $this;
    }

    public function addRepertoire(Repertoire $repertoire): self
    {
        if (!$this->repertoiore->contains($repertoire)) {
            $this->repertoire[] = $repertoire;
            $repertoire->setAccord($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoiore->contains($repertoire)) {
            $this->repertoire->removeElement($repertoire);
            // set the owning side to null (unless already changed)
            if ($repertoire->getAccord() === $this) {
                $repertoire->setAccord(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }
}
