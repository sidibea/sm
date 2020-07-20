<?php

namespace IS\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Portions
 *
 * @ORM\Table(name="portions")
 * @ORM\Entity(repositoryClass="IS\MainBundle\Repository\PortionRepository")
 */
class Portions
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
     * @var int
     *
     * @ORM\Column(name="qteObtenu", type="integer")
     */
    private $qteObtenu;

    /**
     * @var int
     *
     * @ORM\Column(name="qteDestocker", type="integer")
     */
    private $qteDestocker;

    /**
     * @ORM\ManyToOne(targetEntity="Taille", cascade={"persist"} )
     */
    private $taille;

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
     * Set qteObtenu
     *
     * @param integer $qteObtenu
     *
     * @return Portion
     */
    public function setQteObtenu($qteObtenu)
    {
        $this->qteObtenu = $qteObtenu;

        return $this;
    }

    /**
     * Get qteObtenu
     *
     * @return int
     */
    public function getQteObtenu()
    {
        return $this->qteObtenu;
    }

    /**
     * Set qteDestocker
     *
     * @param integer $qteDestocker
     *
     * @return Portion
     */
    public function setQteDestocker($qteDestocker)
    {
        $this->qteDestocker = $qteDestocker;

        return $this;
    }

    /**
     * Get qteDestocker
     *
     * @return int
     */
    public function getQteDestocker()
    {
        return $this->qteDestocker;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * @param int $taille
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;
    }
    
    


}

