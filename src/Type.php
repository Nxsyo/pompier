<?php
// src/Product.php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'type')]
class Type
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string')]
    private string $abr_nom;
    #[ORM\Column(type: 'string')]
    private string $desc;

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
     * Set abrNom.
     *
     * @param string $abrNom
     *
     * @return Type
     */
    public function setAbrNom($abrNom)
    {
        $this->abr_nom = $abrNom;

        return $this;
    }

    /**
     * Get abrNom.
     *
     * @return string
     */
    public function getAbrNom()
    {
        return $this->abr_nom;
    }

    /**
     * Set desc.
     *
     * @param string $desc
     *
     * @return Type
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;

        return $this;
    }

    /**
     * Get desc.
     *
     * @return string
     */
    public function getDesc()
    {
        return $this->desc;
    }
}
