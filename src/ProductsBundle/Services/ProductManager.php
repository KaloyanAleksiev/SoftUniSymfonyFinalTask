<?php

namespace ProductsBundle\Services;

use Doctrine\ORM\EntityManager;
use ProductsBundle\Entity\Product;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class ProductManager
{
    protected $em, $class, $container, $repository;

    public function __construct(EntityManager $em, Product $class,  Container $container)
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

    public function createProduct()
    {
        return new $this->class;
    }

    public function removeProduct(Product $product)
    {
        $this->getEntityManager()->remove($product);
        $this->getEntityManager()->flush();
    }

    public function findProductBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }
}

