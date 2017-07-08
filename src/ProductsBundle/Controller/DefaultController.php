<?php

namespace ProductsBundle\Controller;

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

        return $this->render('@Products/productcategory/list.html.twig', array(
        'productCategories' => $productCategories
    ));
    }


}
