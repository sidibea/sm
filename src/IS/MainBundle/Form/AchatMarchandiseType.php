<?php

namespace IS\MainBundle\Form;

use Doctrine\ORM\EntityRepository;
use IS\MainBundle\Entity\AchatMarchandise;
use IS\MainBundle\Entity\MatierePremiere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AchatMarchandiseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qte')
            ->add('unite', EntityType::class, [
                // looks for choices from this entity
                'class' => 'ISMainBundle:Unite',
                'placeholder' => 'Choisissez une unite de mesure',

                // uses the User.username property as the visible option string
                'choice_label' => 'nom',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('fournisseur')

            ->add('prix')
            ->add('matiere', EntityType::class, [
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
            'data_class' => 'IS\MainBundle\Entity\AchatMarchandise'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'is_mainbundle_achatmarchandise';
    }


}
