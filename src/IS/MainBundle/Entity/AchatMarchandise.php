<?php

namespace IS\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AchatMarchandise
 *
 * @ORM\Table(name="achat_marchandise")
 * @ORM\Entity(repositoryClass="IS\MainBundle\Repository\AchatMarchandiseRepository")
 */
class AchatMarchandise
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
    private $matiere;

    /**
     * @var string
     *
     * @ORM\Column(name="qte", type="decimal", precision=10, scale=2)
     */
    private $qte;

    /**
     * @ORM\ManyToOne(targetEntity="Unite", cascade={"persist"} )
     */
    private $unite;

    /**
     * @var string
     *
     * @ORM\Column(name="fournisseur", type="string", length=255)
     */
    private $fournisseur;

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
     * @var string
     *
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=2)
     */
    private $prix;


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
     * Set matiere
     *
     * @param string $matiere
     *
     * @return AchatMarchandise
     */
    public function setMatiere($matiere)
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * Get matiere
     *
     * @return string
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * Set qte
     *
     * @param string $qte
     *
     * @return AchatMarchandise
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
     * @return AchatMarchandise
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
     * @return AchatMarchandise
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
     * Set prix
     *
     * @param string $prix
     *
     * @return AchatMarchandise
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
     * @return string
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * @param string $fournisseur
     */
    public function setFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;
    }

    /**
     * @return string
     */
    public function getUnite()
    {
        return $this->unite;
    }

    /**
     * @param string $unite
     */
    public function setUnite($unite)
    {
        $this->unite = $unite;
    }




}

