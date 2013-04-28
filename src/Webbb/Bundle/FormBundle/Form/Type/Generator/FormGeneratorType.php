<?php

namespace Webbb\Bundle\FormBundle\Form\Type\Generator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Webbb\Bundle\FormBundle\Helper\FieldHelper;

class FormGeneratorType extends AbstractType
{

    private $validation_types;

    public function __construct($validation_types)
    {
        $this->validation_types = $validation_types;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $builder
        //     ->add('name')
        // ;

        $form_entity = $options['data']; 

        foreach ($form_entity->getFields() as $key => $field) {
            // Non mapped fields: see: http://www.richsage.co.uk/2011/07/20/adding-non-entity-fields-to-your-symfony2-forms/
            // Adding validation constraint as an array: http://stackoverflow.com/questions/8834167/symfony2-how-to-validate-a-form-field-agains-multiple-constraints
            // Dynamic forms from DBB: http://stackoverflow.com/questions/7316461/symfony2-how-to-create-form-based-on-dynamic-parameters-from-db-eav
            $builder
                ->add($field->getName(), $field->getType(), array(
                    "mapped" => false,
                    "constraints" => FieldHelper::getValidationArrayForField($field, $this->validation_types),
                    'required'  => false
                )
            );
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            // 'data_class' => null, //'Webbb\Bundle\FormBundle\Entity\Form',
            'cascade_validation' => true,

            // CUSTOM

        ));
    }

    public function getName()
    {
        return 'webbb_bundle_formbundle_formgeneratortype';
    }
}
