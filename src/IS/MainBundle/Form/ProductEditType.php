<?php

namespace IS\MainBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('variations', CollectionType::class, array(
                'entry_type'   => VariationEditType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'required' => true
            ))


        ;
    }
    


    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'is_mainbundle_product_edit';
    }

    public function getParent()
    {
        return ProductType::class;
    }


}
