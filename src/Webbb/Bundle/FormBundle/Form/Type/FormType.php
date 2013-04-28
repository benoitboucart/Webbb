<?php

namespace Webbb\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormType extends AbstractType
{

    private $field_type;

    public function __construct($field_type)
    {
        $this->field_type = $field_type;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('thankyoutext')
            ->add('recipients')
            ->add('message')
            ->add('description')
            ->add('fields', 'collection', array(
                'type'          => $this->field_type,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Webbb\Bundle\FormBundle\Entity\Form',
            'cascade_validation' => true, // validate sub form type
        ));
    }

    public function getName()
    {
        return 'webbb_bundle_formbundle_formtype';
    }
}
