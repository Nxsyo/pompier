<?php
// src/Product.php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity]
#[ORM\Table(name: 'engins')]
class Engin
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string')]
    private string $full_nom;
    #[ORM\Column(type: 'string')]
    private string $photoLink;
    #[OneToMany(mappedBy: 'engin', targetEntity: Materiel::class)]
    private Collection $materiels;



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
     * Set fullNom.
     *
     * @param string $fullNom
     *
     * @return Engin
     */
    public function setFullNom($fullNom)
    {
        $this->full_nom = $fullNom;

        return $this;
    }

    /**
     * Get fullNom.
     *
     * @return string
     */
    public function getFullNom()
    {
        return $this->full_nom;
    }

    /**
     * Set photoLink.
     *
     * @param string $photoLink
     *
     * @return Engin
     */
    public function setPhotoLink($photoLink)
    {
        $this->photoLink = $photoLink;

        return $this;
    }

    /**
     * Get photoLink.
     *
     * @return string
     */
    public function getPhotoLink()
    {
        return base64_encode($this->photoLink);
    }
}
