<?php

namespace App\Repository\Products;

use App\Entity\Products\ProductVariant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class ProductVariantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductVariant::class);
    }

    public function save(ProductVariant $productVariant): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($productVariant);
        $entityManager->flush();
    }

    public function delete(ProductVariant $productVariant): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($productVariant);
        $entityManager->flush();
    }

    /**
     * @param string $id
     * @return ProductVariant|null
     * @throws NonUniqueResultException
     */
    public function findById(string $id): ?ProductVariant
    {
        return $this->createQueryBuilder("pv")
            ->andWhere("pv.id = :id")
            ->setParameter("id", $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllVariants(int $limit, int $offset): array
    {
        return $this->createQueryBuilder("pv")
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function update(ProductVariant $productVariant): ProductVariant
    {
        $entityManager = $this->getEntityManager();
        $entityManager->flush();
        return $productVariant;
    }
}


