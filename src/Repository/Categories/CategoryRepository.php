<?php

namespace App\Repository\Categories;


use App\Entity\Categories\Category;
use App\Entity\Products\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Category $category): void
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    public function findById(string $id): ?Category
    {
        return $this->entityManager->getRepository(Category::class)->find($id);
    }

    public function delete(Category $category): void
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }

    public function findAllCategory(int $limit, int $offset = 0): array
    {
        return $this->createquerybuilder("p")
            ->setmaxresults($limit)
            ->setfirstresult($offset)
            ->getquery()
            ->getresult();
    }
}