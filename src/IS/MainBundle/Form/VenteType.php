<?php

namespace IS\MainBundle\Form;

use Doctrine\ORM\EntityRepository;
use IS\MainBundle\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VenteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'placeholder' => 'Choisissez un client',
                'attr' => [
                    'class' => 'form-control'
                ],
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->where('m.enabled = :active')
                        ->setParameter('active', true)
                        ->orderBy('m.nom', 'ASC');
                },
                'choice_label' => 'nom'
            ])
            ->add('table')
            ->add('lignes', CollectionType::class, array(
                'entry_type'   => LigneType::class,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'prototype'    => true,
                    'required'     => false,
                    'by_reference' => true,
                    'delete_empty' => true,
                    'attr' => [
                        'class' => 'table discount-collection',
                    ],
                    )
            )
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IS\MainBundle\Entity\Vente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'is_mainbundle_vente';
    }


}
