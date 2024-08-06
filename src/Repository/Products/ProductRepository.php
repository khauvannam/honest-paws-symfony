<?php

namespace App\Repository\Products;

use App\Entity\Products\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($product);
        $entityManager->flush();
    }
    public function update(Product $product): Product
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($product);
        $entityManager->flush();
        return $product;
    }

    public function delete(Product $product): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($product);
        $entityManager->flush();
    }

    /**
     * @param string $id
     * @return Product|null
     * @throws NonUniqueResultException
     */
    public function findById(string $id): ?Product
    {
        return $this->createQueryBuilder("p")
            ->andWhere("p.id = :id")
            ->setParameter("id", $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $name
     * @return Product|null
     * @throws NonUniqueResultException
     */
    public function findByName(string $name): ?Product
    {
        return $this->createQueryBuilder("p")
            ->andWhere("p.name = :name")
            ->setParameter("name", $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Product[]
     */
    public function findAllProducts(int $limit, int $offset = 0): array
    {
        return $this->createquerybuilder("p")
            ->setmaxresults($limit)
            ->setfirstresult($offset)
            ->getquery()
            ->getresult();
    }
    public function findByCategoryId(string $categoryId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->getQuery()
            ->getResult();
    }
}


