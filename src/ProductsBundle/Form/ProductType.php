<?php

namespace ProductsBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Title: ', 'required' => true])
            ->add('subtitle', TextType::class, ['label' => 'SubTitle: ', 'required' => true])
            ->add('description', TextareaType::class, ['label' => 'Description: ', 'required' => true])
            ->add('image', FileType::class, ['data_class' => null, 'label' => 'Upload an image (optional): ', 'required' => false])
            ->add('price', MoneyType::class, ['label' => 'Price: ', 'divisor' => 100, 'required' => true])
            ->add('rank', NumberType::class, ['label' => 'Rank: ', 'required' => true])
            ->add('productCategories', EntityType::class, ['label' => 'Product category (optional): ', 'class' => 'ProductsBundle:ProductCategory', 'choice_label' => 'title', 'multiple' => true, 'expanded' => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProductsBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'productsbundle_product';
    }


}
