<?php

namespace Handy\UbiquitousMusicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MusicItemType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('muiName')
            ->add('muiIsDirectory')
            ->add('muiMuiParent')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Handy\UbiquitousMusicBundle\Entity\MusicItem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'handy_ubiquitousmusicbundle_musicitem';
    }
}
