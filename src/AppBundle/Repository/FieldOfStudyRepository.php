<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * FieldOfStudyRepository
 *
 */
class FieldOfStudyRepository extends EntityRepository
{

    public function findAll($search = null)
    {
        $qb = $this->createQueryBuilder('f');

        if ($search) {
            $qb->andWhere('f.name LIKE :name');
            $qb->setParameter('name', '%'.$search.'%');
        }

        return $qb->getQuery()->getResult();
    }

    public function findByFullTimeMode($year = null)
    {
        $qb = $this->createQueryBuilder('fos');

        $qb->where('fos.mode = :mode');
        $qb->setParameter('mode', 'MODE_FULL_TIME');

        if ($year) {
            $qb->leftJoin('fos.year', 'y')
               ->andWhere('y.year = :year')
               ->setParameter(':year', $year)
            ;
        }

        return $qb->getQuery()->getResult();
    }

    public function findByExtramuralMode($year = null)
    {
        $qb = $this->createQueryBuilder('fos');

        $qb->where('fos.mode = :mode');
        $qb->setParameter('mode', 'MODE_EXTRAMURAL');

        if ($year) {
            $qb->leftJoin('fos.year', 'y')
                ->andWhere('y.year = :year')
                ->setParameter(':year', $year)
            ;
        }

        return $qb->getQuery()->getResult();
    }
}
