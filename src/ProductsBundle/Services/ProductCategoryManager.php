<?php

namespace ProductsBundle\Services;

use Doctrine\ORM\EntityManager;
use ProductsBundle\Entity\Product;
use ProductsBundle\Entity\ProductCategory;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class ProductCategoryManager
{
    protected $em, $class, $container, $repository;

    public function __construct(EntityManager $em, ProductCategory $class,  Container $container)
    {
        $this->em = $em;
        $this->class = $class;
        $this->container = $container;
        $this->repository = $this->em->getRepository($class);
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function createCategory()
    {
        return new $this->class;
    }

    public function removeCategory(ProductCategory $productCategory)
    {
        $this->getEntityManager()->remove($productCategory);
        $this->getEntityManager()->flush();
    }

    public function findProductBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function addProduct(Product $product)
    {
        $productCategory = $this->getClass();
        $productCategory->addProduct($product);
        $this->getEntityManager()->persist($productCategory);
        $this->getEntityManager()->flush();
    }
}