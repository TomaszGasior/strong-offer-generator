<?php

namespace App\Repository;

use Doctrine\ORM\QueryBuilder;

// This trait is designed for repositories of entities with $position field.
// With this trait fetched entities are sorted by $position value by default.

trait DefaultPositionSortingTrait
{
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        if (null === $orderBy) {
            $orderBy = ['position' => 'DESC'];
        }

        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    public function createQueryBuilder($alias, $indexBy = null): QueryBuilder
    {
        return parent::createQueryBuilder($alias, $indexBy)
            ->orderBy($alias.'.position', 'DESC')
        ;
    }
}
