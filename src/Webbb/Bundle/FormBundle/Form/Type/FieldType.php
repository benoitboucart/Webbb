<?php

namespace Webbb\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Webbb\Bundle\FormBundle\Form\DataTransformer\StringToValidationArrayTransformer;

class FieldType extends AbstractType
{

    private $field_types_options;

    public function __construct($field_types_options)
    {
        $this->field_types_options = $field_types_options;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $transformer = new StringToValidationArrayTransformer();

        $builder
            // ->add('name')
            ->add('label')
            ->add('description')
            ->add('type', 'choice', array(
                'choices' => $this->field_types_options,
            ))
            ->add('sortorder')
            ->add('validation')
            // ->add(
            //     $builder->create('validation', 'choice', array(
            //                 'required' => false,
            //                 'expanded' => true,
            //                 'multiple' => true,
            //                 'choices'  => array('test','test2'),
            //             )
            //         )
            //         ->addModelTransformer($transformer)
            // )
            ->add('css')
            ->add('defaultValue')
            ->add('parent')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Webbb\Bundle\FormBundle\Entity\Field'
        ));
    }

    public function getName()
    {
        return 'webbb_bundle_formbundle_fieldtype';
    }
}
