<?php

namespace ProductsBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductCategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Title: ', 'required' => true])
            ->add('description', TextareaType::class, ['label' => 'Description: ', 'required' => true])
            ->add('image', FileType::class, ['label' => 'Upload an image: ', 'required' => false])
            ->add('rank', NumberType::class, ['label' => 'Rank: ', 'required' => true])
            ->add('parent', EntityType::class, ['class' => 'ProductsBundle\Entity\ProductCategory', 'label' => 'Add Parent Category (optional): ', 'required' => false]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProductsBundle\Entity\ProductCategory'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'productsbundle_productcategory';
    }


}
