<?php

namespace IS\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StockPortion
 *
 * @ORM\Table(name="stock_portion")
 * @ORM\Entity(repositoryClass="IS\MainBundle\Repository\StockPortionRepository")
 */
class StockPortion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="MatierePremiere", cascade={"persist"} )
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity="Portions", cascade={"persist"} )
     */
    private $portion;

    /**
     * @ORM\ManyToOne(targetEntity="Vente", cascade={"persist", "remove"} )
     */
    private $vente;


    /**
     * @var string
     *
     * @ORM\Column(name="taille", type="string", length=255, nullable=true)
     */
    private $taille;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="qte", type="decimal", precision=10, scale=2)
     */
    private $qte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set produit
     *
     * @param string $produit
     *
     * @return StockMatiere
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return string
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set qte
     *
     * @param string $qte
     *
     * @return StockMatiere
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return string
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return StockMatiere
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return StockMatiere
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * @param mixed $taille
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;
    }

    /**
     * @return mixed
     */
    public function getPortion()
    {
        return $this->portion;
    }

    /**
     * @param mixed $portion
     */
    public function setPortion($portion)
    {
        $this->portion = $portion;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getVente()
    {
        return $this->vente;
    }

    /**
     * @param mixed $vente
     */
    public function setVente($vente)
    {
        $this->vente = $vente;
    }



    


}

