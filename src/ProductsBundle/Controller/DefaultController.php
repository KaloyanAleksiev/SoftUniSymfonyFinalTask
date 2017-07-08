<?php

namespace ProductsBundle\Controller;

use ProductsBundle\Entity\Product;
use ProductsBundle\Entity\ProductCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->categoryListAction();
    }

    /**
     * @Route("/category/list", name="product-category_list")
     * @Method("GET")
     */
    public function categoryListAction()
    {
        $productCategories = $this->get('productsbundle.product_category_manager')
            ->getEntityManager()
            ->getRepository('ProductsBundle:ProductCategory')
            ->findAllCategoriesWithImagesOrderedByRank();

        return $this->render('@Products/Default/category_list.html.twig', array(
        'productCategories' => $productCategories
    ));
    }

    /**
     * @Route("/category/{id}/list", name="product-category_list_by_parent")
     * @Method("GET")
     */
    public function categoryListByParentAction(ProductCategory $productCategory)
    {
        $productCategories = $this->get('productsbundle.product_category_manager')
            ->getEntityManager()
            ->getRepository('ProductsBundle:ProductCategory')
            ->findAllSubCategoriesWithImagesOrderedByRank($productCategory->getId());

        return $this->render('@Products/Default/category_list.html.twig', array(
            'productCategories' => $productCategories,
            'parentCategory' => $productCategory
        ));

    }

    /**
     * @Route("/product/{id}/list", name="product-product_list_by_category")
     * @Method("GET")
     */
    public function productListByCategory(ProductCategory $productCategory)
    {

        $products = $productCategory->getProducts();

        return $this->render('@Products/Default/product_list.html.twig', array(
            'products' => $products,
            'parentCategory' => $productCategory
        ));
    }

    /**
     * @Route("/product/{id}/view",name="product_view")
     * @Method("GET")
     */
    public function productViewAction(Product $product)
    {
        return $this->render('@Products/Default/product_view.html.twig', array(
            'product' => $product
        ));
    }
}
