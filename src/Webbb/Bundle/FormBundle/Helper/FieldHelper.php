<?php

namespace Webbb\Bundle\FormBundle\Helper;

use Webbb\Bundle\FormBundle\Entity\Field;


class FieldHelper
{

	/**
	 * This function gives an array with validation classes for the given field
	 */
	public static function getValidationArrayForField(Field $field, $validation_classes){
        if(!$field || !$field->getValidation())
            return array();

        $validation_properties = explode(',', $field->getValidation());
        // array(
        //     'notblank'          => '\Symfony\Component\Validator\Constraints\NotBlank',
        // )
        $validation_array = array();
        foreach ($validation_properties as $validation_key) {
            $validation_params = array();
            if(strpos($validation_key, '[')){
                // Extra parameters, given to the constructor of the validation class
                $params = preg_replace('/\s+/', '', str_replace(
                    array('[',']'),
                    array('',''),
                    strstr($validation_key, '[')
                ));  // example: [min:20;max:30] // must be before, because $validation_key will be overriden below!
                $validation_key = substr($validation_key, 0, strpos($validation_key,'[')); // example: length
                $params = explode(';',$params) ;
                foreach($params as $param) { 
                    $parameter = explode(':', $param);
                    $validation_params[$parameter[0]] = $parameter[1]; 
                }
            }

        	if(isset($validation_classes[$validation_key])){
        		$validation_array[] = new $validation_classes[$validation_key]($validation_params);
            }
        }

// echo '<pre>';\Doctrine\Common\Util\Debug::dump($validation_array); echo '</pre>';
// echo '<pre>';\Doctrine\Common\Util\Debug::dump($validation_classes); echo '</pre>'; exit();
        return $validation_array;
	}
}