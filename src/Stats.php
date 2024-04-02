<?php
// src/Product.php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity]
#[ORM\Table(name: 'stats')]
class Stats
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string')]
    private string $titre;
    #[ORM\Column(type: 'string')]
    private string $chiffre;
    #[ORM\Column(type: 'string')]
    private string $short_desc;
    #[ORM\Column(type: 'string')]
    private string $long_desc;
    #[ORM\Column(type: 'string')]
    private string $icon;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre.
     *
     * @param string $titre
     *
     * @return Stats
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre.
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set chiffre.
     *
     * @param string $chiffre
     *
     * @return Stats
     */
    public function setChiffre($chiffre)
    {
        $this->chiffre = $chiffre;

        return $this;
    }

    /**
     * Get chiffre.
     *
     * @return string
     */
    public function getChiffre()
    {
        return $this->chiffre;
    }

    /**
     * Set shortDesc.
     *
     * @param string $shortDesc
     *
     * @return Stats
     */
    public function setShortDesc($shortDesc)
    {
        $this->short_desc = $shortDesc;

        return $this;
    }

    /**
     * Get shortDesc.
     *
     * @return string
     */
    public function getShortDesc()
    {
        return $this->short_desc;
    }

    /**
     * Set longDesc.
     *
     * @param string $longDesc
     *
     * @return Stats
     */
    public function setLongDesc($longDesc)
    {
        $this->long_desc = $longDesc;

        return $this;
    }

    /**
     * Get longDesc.
     *
     * @return string
     */
    public function getLongDesc()
    {
        return $this->long_desc;
    }

    /**
     * Set icon.
     *
     * @param string $icon
     *
     * @return Stats
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }
}
