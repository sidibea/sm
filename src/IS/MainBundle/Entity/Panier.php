<?php

namespace IS\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IS\MainBundle\Form\VariationEditType;

/**
 * Panier
 *
 * @ORM\Table(name="panier")
 * @ORM\Entity(repositoryClass="IS\MainBundle\Repository\PanierRepository")
 */
class Panier
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Vente", inversedBy="paniers", cascade={"persist", "remove"} )
     */
    private $vente;

    /**
     * @var int
     *
     * @ORM\Column(name="qte", type="integer")
     */
    private $qte;

    /**
     * @ORM\ManyToOne(targetEntity="Variation", cascade={"persist"} )
     */
    private $variation;

    /**
     * @ORM\ManyToOne(targetEntity="Product", cascade={"persist"} )
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"} )
     */
    private $user;







    public function setVente($vente)
    {
        $this->vente = $vente;

        return $this;
    }

    /**
     * Get ventes
     *
     * @return string
     */
    public function getVente()
    {
        return $this->vente;
    }



    public function setVariation($variation)
    {
        $this->variation = $variation;

        return $this;
    }

    /**
     * Get variation
     *
     * @return string
     */
    public function getVariation()
    {
        return $this->variation;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * @param int $qte
     */
    public function setQte($qte)
    {
        $this->qte = $qte;
    }





}

