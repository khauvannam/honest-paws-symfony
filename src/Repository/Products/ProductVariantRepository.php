<?php

namespace App\Repository;

use App\Entity\Products\ProductVariant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @extends ServiceEntityRepository<ProductVariant>
 *
 * @method ProductVariant|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductVariant|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductVariant[]    findAll()
 * @method ProductVariant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
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
        return $this->createQueryBuilder('pv')
            ->andWhere('pv.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $productId
     * @return ProductVariant[]
     */
    public function findByProductId(string $productId): array
    {
        return $this->createQueryBuilder('pv')
            ->andWhere('pv.productId = :productId')
            ->setParameter(key: 'productId', value: $productId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $variantName
     * @return ProductVariant|null
     * @throws NonUniqueResultException
     */
    public function findByVariantName(string $variantName): ?ProductVariant
    {
        return $this->createQueryBuilder('pv')
            ->andWhere('pv.variantName = :variantName')
            ->setParameter('variantName', $variantName)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return ProductVariant[]
     */
    public function findAllVariants(int $limit, int $offset): array
    {
        return $this->createQueryBuilder('pv')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
}

?>
