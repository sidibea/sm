<?php

namespace IS\MainBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VariationEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix')
            ->add('compositions', CollectionType::class, array(
                'entry_type'   => CompositionType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'required' => true,
                'entry_options' => [
                    'label' => false
                ]
            ))

            ->add('taille', EntityType::class, [
                // looks for choices from this entity
                'class' => 'ISMainBundle:Taille',
                'placeholder' => 'Choisissez une taille',

                // uses the User.username property as the visible option string
                'choice_label' => 'nom',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IS\MainBundle\Entity\Variation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'is_mainbundle_variation_edit';
    }


}
