<?php

namespace Webbb\Bundle\FormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use DMS\Filter\Rules as Filter;

/**
 * Form
 *
 * @ORM\Table(name="webbb_form")
 * @ORM\Entity(repositoryClass="Webbb\Bundle\FormBundle\Entity\FormRepository")
 * @UniqueEntity("name")
 */
class Form
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fields = new \Doctrine\Common\Collections\ArrayCollection();
        $this->entries = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * ToString
     */
    public function __toString()
    {
        return $this->name;
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
     * @ORM\OneToMany(targetEntity="Field", mappedBy="form",cascade={"persist", "remove"})
     **/
    private $fields;

    /**
     * @ORM\OneToMany(targetEntity="Entry", mappedBy="form")
     **/
    private $entries;



    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Assert\NotBlank()
     *
     * @Filter\StripNewlines()
     * @Filter\ToLower()
     * @Filter\Alnum(allowWhitespace=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="thankyoutext", type="text")
     *
     * @Assert\NotBlank()
     */
    private $thankyoutext;

    /**
     * @var string
     *
     * @ORM\Column(name="recipients", type="text")
     *
     * @Assert\NotBlank()
     */
    private $recipients;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     *
     * @Assert\NotBlank()
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


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
     * @return Form
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
     * Set thankyoutext
     *
     * @param string $thankyoutext
     * @return Form
     */
    public function setThankyoutext($thankyoutext)
    {
        $this->thankyoutext = $thankyoutext;
    
        return $this;
    }

    /**
     * Get thankyoutext
     *
     * @return string 
     */
    public function getThankyoutext()
    {
        return $this->thankyoutext;
    }

    /**
     * Set recipients
     *
     * @param string $recipients
     * @return Form
     */
    public function setRecipients($recipients)
    {
        $this->recipients = $recipients;
    
        return $this;
    }

    /**
     * Get recipients
     *
     * @return string 
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Form
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Form
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
     * Add fields
     *
     * @param \Webbb\Bundle\FormBundle\Entity\Field $fields
     * @return Form
     */
    public function addField(\Webbb\Bundle\FormBundle\Entity\Field $fields)
    {
        $this->fields[] = $fields;
        // Add the relation between "forms" and "fields"
        $fields->setForm($this);

        return $this;
    }

    /**
     * Remove fields
     *
     * @param \Webbb\Bundle\FormBundle\Entity\Field $fields
     */
    public function removeField(\Webbb\Bundle\FormBundle\Entity\Field $fields)
    {
        $this->fields->removeElement($fields);
    }

    /**
     * Get fields
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFields()
    {
        return $this->fields;
    }
    // /**
    //  * Set fields
    //  *
    //  * @param ArrayCollection $fields
    //  * @return Form
    //  */
    // public function setFields(ArrayCollection $fields)
    // {
    //     foreach ($fields as $field) {
    //         $field->addForm($this);
    //     }
    //     $this->fields = $fields;
    
    //     return $this;
    // }


    /**
     * Add entries
     *
     * @param \Webbb\Bundle\FormBundle\Entity\Entry $entries
     * @return Form
     */
    public function addEntry(\Webbb\Bundle\FormBundle\Entity\Entry $entries)
    {
        $this->entries[] = $entries;
    
        return $this;
    }

    /**
     * Remove entries
     *
     * @param \Webbb\Bundle\FormBundle\Entity\Entry $entries
     */
    public function removeEntry(\Webbb\Bundle\FormBundle\Entity\Entry $entries)
    {
        $this->entries->removeElement($entries);
    }

    /**
     * Get entries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEntries()
    {
        return $this->entries;
    }
}