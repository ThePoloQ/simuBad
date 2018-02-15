<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class JoueurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
          ->add('sexe')
          ->add('licence')
          ->add('dateInscription')
          ->add('estLA')
          ->add('estSimple')
          ->add('estDouble')
          ->add('partenaireDH')
          ->add('partenaireDD')
          ->add('estMixte')
          ->add('partenaireMX')
          ->add('groupes')
          ->add('DhId', HiddenType::class)
          ->add('DdId', HiddenType::class)
          ->add('MxId', HiddenType::class)
          ->add('coteSimple')
          ->add('coteDouble')
          ->add('coteMixte');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Joueur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_joueur';
    }


}
