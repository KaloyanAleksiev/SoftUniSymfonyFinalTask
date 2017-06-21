<?php

namespace ProductsBundle\Services;

use Doctrine\ORM\EntityManager;
use ProductsBundle\Entity\Product;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class ProductManager
{
    protected $em, $class, $container, $repository;

    public function __construct(EntityManager $em, Product $class, Container $container)
    {
        $this->em = $em;
        $this->class = $class;
        $this->container = $container;
        $this->repository = $this->em->getRepository($class);
    }

}