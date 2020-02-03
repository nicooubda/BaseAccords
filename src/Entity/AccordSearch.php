<?php

namespace App\Entity;

class AccordSearch
{
    private $titre;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $langue;
    /**
     * @var string
     */
    private $resume;

    /**
     * @var string
     */
    private $lieu;

    /**
     * @var string
     */
    private $motCle;
    /**
     * @var int
     */
    private $dates;

    public function getTitre()
    {
        return $this->titre;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getDates()
    {
        return $this->dates;
    }

    public function getLangue()
    {
        return $this->langue;
    }

    public function getLieu()
    {
        return $this->lieu;
    }

    public function getMotCle()
    {
        return $this->motCle;
    }

    public function getResume()
    {
        return $this->resume;
    }

    /**
     * @param string|null $titre
     *
     * @return AccordSearch
     */
    public function setTitre($titre): AccordSearch
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @param string|null $type
     *
     * @return AccordSearch
     */
    public function setType($type): AccordSearch
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string|null $type
     *
     * @return AccordSearch
     */
    public function setResume($resume): AccordSearch
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * @param string|null $langue
     *
     * @return AccordSearch
     */
    public function setLangue($langue): AccordSearch
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * @param string|null $lieu
     *
     * @return AccordSearch
     */
    public function setLieu($lieu): AccordSearch
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @param string|null $motCle
     *
     * @return AccordSearch
     */
    public function setMotCle($motCle): AccordSearch
    {
        $this->motCle = $motCle;

        return $this;
    }

    /**
     * @param string|null $motCle
     *
     * @return AccordSearch
     */
    public function setDates($dates): AccordSearch
    {
        $this->dates = $dates;

        return $this;
    }
}
