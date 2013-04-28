<?php
namespace Webbb\Bundle\FormBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
// use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Transform a validation string ("comma" separated) to an array of validation properties
 */
class StringToValidationArrayTransformer implements DataTransformerInterface
{
    /**
     */
    public function __construct()
    {
    }

    /**
     * Transforms an array of validation properties to a string.
     *
     */
    public function transform($validation_string)
    {
        if (!$validation_string) {
            return null;
        }

        $validation_array = explode(",", trim($validation_string));


        // if (null === $issue) {
        //     throw new TransformationFailedException(sprintf(
        //         'An issue with validation_string "%s" does not exist!',
        //         $validation_string
        //     ));
        // }

        return $validation_array;
    }

    /**
     * Transforms a string (validation meta info) to an array of validation properties.
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($validation_array)
    {
        if (null === $validation_array) {
            return "";
        }

        return preg_replace('/\s+/', '', implode(",", trim($validation_array))); // remove all whitespace
    }
}
