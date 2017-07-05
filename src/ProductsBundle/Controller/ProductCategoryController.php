<?php

namespace ProductsBundle\Controller;

use ProductsBundle\Entity\ProductCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Productcategory controller.
 *
 * @Route("admin/product-category")
 */
class ProductCategoryController extends Controller
{
    /**
     * Lists all productCategory entities.
     *
     * @Route("/", name="admin_product-category_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $productCategories = $em->getRepository('ProductsBundle:ProductCategory')->findAll();

        return $this->render('ProductsBundle:productcategory:index.html.twig', array(
            'productCategories' => $productCategories,
        ));
    }

    /**
     * Creates a new productCategory entity.
     *
     * @Route("/new", name="admin_product-category_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $productCategory = new Productcategory();
        $form = $this->createForm('ProductsBundle\Form\ProductCategoryType', $productCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productCategory->setSlug($this->get('slugger')->slugify($productCategory->getTitle()));

            $productCategory->setCreatedAt(new \DateTime());
            $productCategory->setUpdatedAt(new \DateTime());

            $image = $productCategory->getImage();
            if($image != null) {
                $imageName = $this->get('productsbundle.product_category_uploader')->upload($image);
                $productCategory->setImage($imageName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($productCategory);
            $em->flush();

            return $this->redirectToRoute('admin_product-category_show', array('id' => $productCategory->getId()));
        }

        return $this->render('ProductsBundle:productcategory:new.html.twig', array(
            'productCategory' => $productCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a productCategory entity.
     *
     * @Route("/{id}", name="admin_product-category_show")
     * @Method("GET")
     */
    public function showAction(ProductCategory $productCategory)
    {
        $deleteForm = $this->createDeleteForm($productCategory);

        return $this->render('ProductsBundle:productcategory:show.html.twig', array(
            'productCategory' => $productCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing productCategory entity.
     *
     * @Route("/{id}/edit", name="admin_product-category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ProductCategory $productCategory)
    {

        $deleteForm = $this->createDeleteForm($productCategory);
        $editForm = $this->createForm('ProductsBundle\Form\ProductCategoryType', $productCategory);
        $uploadedImage = $productCategory->getImage();
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $productCategory->setSlug($this->get('slugger')->slugify($productCategory->getTitle()));

            $productCategory->setUpdatedAt(new \DateTime());

            $image = $productCategory->getImage();
            if($image != null) {
                $imageName = $this->get('productsbundle.product_category_uploader')->upload($image);
                $productCategory->setImage($imageName);
            }elseif ($uploadedImage != null){
                $productCategory->setImage($uploadedImage);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($productCategory);
            $em->flush();

            return $this->redirectToRoute('admin_product-category_edit', array('id' => $productCategory->getId()));
        }

        return $this->render('ProductsBundle:productcategory:edit.html.twig', array(
            'productCategory' => $productCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a productCategory entity.
     *
     * @Route("/{id}", name="admin_product-category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ProductCategory $productCategory)
    {
        $form = $this->createDeleteForm($productCategory);
        $children = $productCategory->getChildren();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($children != null){
                throw new \Exception('You are trying to delete a parent category. Please consider removing all children categories first!');
            }
            $em = $this->getDoctrine()->getManager();
            $em->remove($productCategory);
            $em->flush();
        }

        return $this->redirectToRoute('admin_product-category_index');
    }

    /**
     * Creates a form to delete a productCategory entity.
     *
     * @param ProductCategory $productCategory The productCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProductCategory $productCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_product-category_delete', array('id' => $productCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/category/list", name="admin_product-category_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $productCategories = $this->get('productsbundle.product_category_manager')
            ->getEntityManager()
            ->getRepository('ProductsBundle:ProductCategory')
            ->findAllCategoriesWithImagesOrderedByRank();

        return $this->render('ProductsBundle:productcategory:list.html.twig', array(
            'productCategories' => $productCategories
        ));

    }

    /**
     * @Route("/category/{id}/list", name="admin_product-category_list_by_parent")
     * @Method("GET")
     */

    public function listByParentCategoryAction(ProductCategory $productCategory){

        $productCategories = $this->get('productsbundle.product_category_manager')
            ->getEntityManager()
            ->getRepository('ProductsBundle:ProductCategory')
            ->findAllSubCategoriesWithImagesOrderedByRank($productCategory->getId());

        return $this->render('ProductsBundle:productcategory:list.html.twig', array(
            'productCategories' => $productCategories,
            'parentCategory' => $productCategory
        ));
    }

    /**
     * @Route("/product/{id}/list", name="admin_product-product_list_by_category")
     * @Method("GET")
     */

    public function listProductListByCategory(ProductCategory $productCategory){

        $products = $productCategory->getProducts();


        return $this->render('ProductsBundle:product:list.html.twig', array(
            'products' => $products,
            'parentCategory' => $productCategory
        ));
    }

}
