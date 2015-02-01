<?php

namespace Handy\FlightMonitorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AirlineType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('airName')
            ->add('airUrl')
            ->add('airPost')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Handy\FlightMonitorBundle\Entity\Airline'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'handy_flightmonitorbundle_airline';
    }
}
