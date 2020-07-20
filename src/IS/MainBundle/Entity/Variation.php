<?php

namespace IS\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Variation
 *
 * @ORM\Table(name="variation")
 * @ORM\Entity(repositoryClass="IS\MainBundle\Repository\VariationRepository")
 */
class Variation
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
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="variations")
     */
    private $produit;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Taille::class, cascade={"persist", "remove"})
     */
    private $taille;

    /**
     * @ORM\ManyToMany(targetEntity=Composition::class, cascade={"persist", "remove"})
     */
    private $compositions;


    /**
     * @ORM\OneToMany(targetEntity="Panier", mappedBy="Vente", cascade={"persist"} )
     */
    private $paniers;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->compositions = new ArrayCollection();
    }


    /**
     * Set paniers
     *
     * @param string $paniers
     *
     * @return Panier
     */
    public function setPaniers($paniers)
    {
        $this->paniers = $paniers;

        return $this;
    }

    /**
     * Get paniers
     *
     * @return string
     */
    public function getPaniers()
    {
        return $this->paniers;
    }



    public function getCompositions()
    {
        return $this->compositions;
    }
    public function addComposition(Composition $composition)
    {
        if (!$this->compositions->contains($composition)) {
            $this->compositions[] = $composition;
        }
        return $this;
    }
    public function removeComposition(Composition $composition)
    {
        if ($this->compositions->contains($composition)) {
            $this->compositions->removeElement($composition);
        }
        return $this;
    }

    /**
     * Set produit
     *
     * @param string $produit
     *
     * @return Variation
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
     * Set prix
     *
     * @param string $prix
     *
     * @return Variation
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set taille
     *
     * @param string $taille
     *
     * @return Variation
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * Get taille
     *
     * @return string
     */
    public function getTaille()
    {
        return $this->taille;
    }




}

