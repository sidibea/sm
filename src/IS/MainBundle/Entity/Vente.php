<?php

namespace IS\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Vente
 *
 * @ORM\Table(name="vente")
 * @ORM\Entity(repositoryClass="IS\MainBundle\Repository\VenteRepository")
 */
class Vente
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
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"} )
     */
    private $saleBy;



    /**
     * @ORM\ManyToOne(targetEntity="Client", cascade={"persist"} )
     */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column(name="no_table", type="string", length=2, nullable=true)
     */
    private $table;

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
     * @ORM\OneToMany(targetEntity="Panier", mappedBy="vente", cascade={"persist", "remove"} )
     */
    private $paniers;


    /**
     * @var bool
     *
     * @ORM\Column(name="is_valid", type="boolean")
     */
    private $isValid;


    public function __construct()
    {
        $this->paniers = new ArrayCollection();
    }





    public function getPaniers()
    {
        return $this->paniers;
    }


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
     * Set client
     *
     * @param string $client
     *
     * @return Vente
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Vente
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
     * @return Vente
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


    public function addPanier(Panier $panier)
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers[] = $panier;
        }
        return $this;
    }
    public function removeLigne(Panier $panier)
    {
        if ($this->paniers->contains($panier)) {
            $this->paniers->removeElement($panier);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @return mixed
     */
    public function getSaleBy()
    {
        return $this->saleBy;
    }

    /**
     * @param mixed $saleBy
     */
    public function setSaleBy($saleBy)
    {
        $this->saleBy = $saleBy;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * @param bool $isValid
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }






}

