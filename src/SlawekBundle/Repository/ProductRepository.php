<?php

namespace SlawekBundle\Repository;

use SlawekBundle\Entity\Product;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{


     /**
     * Znajduje wszystkie produkty których skład jest większy niż parametr
     * @param integer $amount
     * @return Product[]
     */
    public function findAllByAmountGreaterThan($amount)
    {
        return $this->createQueryBuilder('product')
            ->andWhere('product.amount > :amount')
            ->setParameter('amount', $amount)
            ->getQuery()
            ->execute();
    }

}

