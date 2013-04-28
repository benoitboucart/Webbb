<?php

namespace Webbb\Bundle\FormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use DMS\Filter\Rules as Filter;

/**
 * Field
 *
 * @ORM\Table(name="webbb_form_field")
 * @ORM\Entity(repositoryClass="Webbb\Bundle\FormBundle\Entity\FieldRepository")
 * @UniqueEntity("name")
 * @ORM\HasLifecycleCallbacks()
 */
class Field
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * ToString
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersistLifecycle()
    {
        $this->name = \Webbb\Component\Helper\StringHelper::slugify($this->label);
    }

    

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Form", inversedBy="fields")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id")
     */
    private $form;



    /**
     * Unique name of the field
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     */
    private $name;

    /**
     * Unique label of the field
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     *
     * @Assert\NotBlank()
     *
     */
    private $label;

    /**
     * Description of the field
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * Type of field: file-upload, number, url, phone
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     *
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="sortorder", type="integer")
     */
    private $sortorder;

    /**
     * @var string
     *
     * @ORM\Column(name="validation", type="string", length=110, nullable=true)
     */
    private $validation;

    /**
     * Extra CSS classes to be added to form row
     * @var string
     *
     * @ORM\Column(name="css", type="string", length=255, nullable=true)
     */
    private $css;

    /**
     * Default value for this form field
     * @var string
     *
     * @ORM\Column(name="default_value", type="string", length=255, nullable=true)
     */
    private $defaultValue;

    /**
     * Parent of this field
     * @var Field
     * 
     * @ORM\ManyToOne(targetEntity="Field", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     **/
    private $parent;
    /**
     * @ORM\OneToMany(targetEntity="Field", mappedBy="parent")
     **/
    private $children;

    /**
     * @var array
     *
     * @ORM\Column(name="extra_parameters", type="json_array", nullable=true)
     */
    private $extraParameters;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Field
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Field
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Field
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sortorder
     *
     * @param integer $sortorder
     * @return Field
     */
    public function setSortorder($sortorder)
    {
        $this->sortorder = $sortorder;
    
        return $this;
    }

    /**
     * Get sortorder
     *
     * @return integer 
     */
    public function getSortorder()
    {
        return $this->sortorder;
    }

    /**
     * Set validation
     *
     * @param string $validation
     * @return Field
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    
        return $this;
    }

    /**
     * Get validation
     *
     * @return string 
     */
    public function getValidation()
    {
        // return array('test');
        // new \Symfony\Component\Validator\Constraints\NotBlank(array(/* "message" => "Please accept the Terms and conditions in order to register" */ )),
        // new \Symfony\Component\Validator\Constraints\Email(array()),

        return $this->validation;
    }

    /**
     * Set css
     *
     * @param string $css
     * @return Field
     */
    public function setCss($css)
    {
        $this->css = $css;
    
        return $this;
    }

    /**
     * Get css
     *
     * @return string 
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * Set defaultValue
     *
     * @param string $defaultValue
     * @return Field
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    
        return $this;
    }

    /**
     * Get defaultValue
     *
     * @return string 
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }


    /**
     * Set parent
     *
     * @param \Webbb\Bundle\FormBundle\Entity\Field $parent
     * @return Block
     */
    public function setParent(\Webbb\Bundle\FormBundle\Entity\Field $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \Webbb\Bundle\FormBundle\Entity\Field 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \Webbb\Bundle\FormBundle\Entity\Field $children
     * @return Block
     */
    public function addChildren(\Webbb\Bundle\FormBundle\Entity\Field $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \Webbb\Bundle\FormBundle\Entity\Field $children
     */
    public function removeChildren(\Webbb\Bundle\FormBundle\Entity\Field $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }
    public function setChildren($in_children)
    {
        return $this->children=$in_children;
    }
    
    /**
     * Set form
     *
     * @param \Webbb\Bundle\FormBundle\Entity\Form $form
     * @return Field
     */
    public function setForm(\Webbb\Bundle\FormBundle\Entity\Form $form = null)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return \Webbb\Bundle\FormBundle\Entity\Form 
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set extraParameters
     *
     * @param array $extraParameters
     * @return Field
     */
    public function setExtraParameters($extraParameters)
    {
        $this->extraParameters = $extraParameters;
    
        return $this;
    }

    /**
     * Get extraParameters
     *
     * @return array 
     */
    public function getExtraParameters()
    {
        return $this->extraParameters;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return Field
     */
    public function setLabel($label)
    {
        $this->label = $label;
    
        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }
}