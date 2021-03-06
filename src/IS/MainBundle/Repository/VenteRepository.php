<?php

namespace IS\MainBundle\Repository;

/**
 * VenteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VenteRepository extends \Doctrine\ORM\EntityRepository
{
    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT v
                FROM ISMainBundle:Product v
                WHERE v.nom LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getArrayResult();
    }
}
