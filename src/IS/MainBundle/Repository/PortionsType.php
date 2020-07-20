<?php

namespace IS\MainBundle\Form;

use Doctrine\ORM\EntityRepository;
use IS\MainBundle\Entity\MatierePremiere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PortionsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qteObtenu')
            ->add('qteDestocker')
            ->add('taille', ChoiceType::class, [
                'placeholder' => 'Choisissez une taille',
                'choices'  => [
                    'Large' => 'L',
                    'Medium' => 'M',
                ],
            ])
            ->add('produit', EntityType::class, [
                'class' => MatierePremiere::class,
                'placeholder' => 'Choisissez une matiere premiere',
                'attr' => [
                    'class' => 'form-control'
                ],
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->where('m.isEnabled = :active')
                        ->setParameter('active', true)
                        ->orderBy('m.nom', 'ASC');
                },
                'choice_label' => 'nom'
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IS\MainBundle\Entity\Portions'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'is_mainbundle_portions';
    }


}
