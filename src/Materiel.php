<?php
// src/Product.php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity]
#[ORM\Table(name: 'materiels')]
class Materiel
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string')]
    private string $nom;
    #[ORM\Column(type: 'string')]
    private string $photoLink;
    #[ORM\Column(type: 'string')]
    private string $description;
    #[ManyToOne(targetEntity: Engin::class)]
    #[JoinColumn(name: 'engin_id', referencedColumnName:'id')]
    private Engin|null $engin = null;


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
     * Set nom.
     *
     * @param string $nom
     *
     * @return Materiel
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set photoLink.
     *
     * @param string $photoLink
     *
     * @return Materiel
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

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Materiel
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set engin.
     *
     * @param \Engin|null $engin
     *
     * @return Materiel
     */
    public function setEngin(\Engin $engin = null)
    {
        $this->engin = $engin;

        return $this;
    }

    /**
     * Get engin.
     *
     * @return \Engin|null
     */
    public function getEngin()
    {
        return $this->engin;
    }
}
