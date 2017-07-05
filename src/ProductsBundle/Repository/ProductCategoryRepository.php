<?php

namespace ProductsBundle\Repository;

/**
 * ProductCategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductCategoryRepository extends \Doctrine\ORM\EntityRepository
{

    public function findAllCategoriesWithImagesOrderedByRank()
    {
        $qb = $this->createQueryBuilder('pc');
        $qb->where('pc.image != :identifier')
            ->setParameter('identifier', '<null>');
        $qb->orderBy('pc.rank');

        return $qb->getQuery()->getResult();
    }

    public function findAllSubCategoriesWithImagesOrderedByRank($parentId)
    {
        $qb = $this->createQueryBuilder('pc');
        $qb->where('pc.image != :identifier')
            ->setParameter('identifier', '<null>');
        $qb->andWhere('pc.parent = :parent')
            ->setParameter('parent', $parentId);
        $qb->orderBy('pc.rank');

        return $qb->getQuery()->getResult();
    }

}