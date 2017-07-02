<?php

namespace ProductsBundle\Controller;

use ProductsBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 * @Route("admin/product")
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/", name="admin_product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('ProductsBundle:Product')->findAll();

        return $this->render('ProductsBundle:product:index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="admin_product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('ProductsBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('mailer')->sendNotificationForNewProduct();
            $product->setSlug($this->get('slugger')->slugify($product->getTitle()));

            $product->setCreatedAt(new \DateTime());
            $product->setUpdatedAt(new \DateTime());

            $image = $product->getImage();
            if($image != null){
                $imageName = $this->get('productsbundle.product_uploader')->upload($image);
                $product->setImage($imageName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('admin_product_show', array('id' => $product->getId()));
        }

        return $this->render('ProductsBundle:product:new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="admin_product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('ProductsBundle:product:show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="admin_product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('ProductsBundle\Form\ProductType', $product);
        $uploadedImage = $product->getImage();
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $product->setSlug($this->get('slugger')->slugify($product->getTitle()));

            $product->setUpdatedAt(new \DateTime());

            $image = $product->getImage();
            if($image != null){
                $imageName = $this->get('productsbundle.product_uploader')->upload($image);
                $product->setImage($imageName);
            }elseif ($uploadedImage != null){
                $product->setImage($uploadedImage);
            }
            $em = $this->get('productsbundle.product_manager')->getEntityManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('admin_product_edit', array('id' => $product->getId()));
        }

        return $this->render('ProductsBundle:product:edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="admin_product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('admin_product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/product/list", name="admin_product_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $products = $this->get('productsbundle.product_manager')
            ->getEntityManager()
            ->getRepository('ProductsBundle:Product')
            ->findAllWithImagesOrderedByRank();
        return $this->render('ProductsBundle:product:list.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * @Route("/product/{id}/view",name="admin_product_view")
     * @Method("GET")
     */
    public function viewAction(Product $product)
    {
        return $this->render('ProductsBundle:product:view.html.twig', array(
            'product' => $product
        ));
    }
}
