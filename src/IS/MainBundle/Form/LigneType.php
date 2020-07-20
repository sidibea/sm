<?php

namespace IS\MainBundle\Form;

use Doctrine\ORM\EntityRepository;
use IS\MainBundle\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LigneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit', EntityType::class, [
                'class' => Product::class,
                'placeholder' => 'Choisissez un produit',
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
            ->add('qte');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IS\MainBundle\Entity\Ligne'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'is_mainbundle_ligne';
    }


}
