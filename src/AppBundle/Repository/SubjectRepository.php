<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SubjectRepository
 *
 */
class SubjectRepository extends EntityRepository
{
    public function getForAjaxSearch($term)
    {
        $qb = $this->createQueryBuilder('s');

        $qb
            ->select('s.id', "CONCAT( CONCAT(s.name, ' | '),  s.code) AS text")
            ->where('s.name LIKE :name')
            ->orWhere('s.code LIKE :name')
            ->setParameter('name', '%'.$term.'%')
        ;

        return $qb->getQuery()->getResult();
    }
}
