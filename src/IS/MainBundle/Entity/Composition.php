<?php

namespace IS\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductComposition
 *
 * @ORM\Table(name="composition")
 * @ORM\Entity(repositoryClass="IS\MainBundle\Repository\ProductCompositionRepository")
 */
class Composition
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


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
     * @return mixed
     */
    public function getUnite()
    {
        return $this->unite;
    }

    /**
     * @param mixed $unite
     */
    public function setUnite($unite)
    {
        $this->unite = $unite;
    }








}

