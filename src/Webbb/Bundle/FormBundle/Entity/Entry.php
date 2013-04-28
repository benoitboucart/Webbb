<?php

namespace Webbb\Bundle\FormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entry
 *
 * @ORM\Table(name="webbb_form_entry")
 * @ORM\Entity(repositoryClass="Webbb\Bundle\FormBundle\Entity\EntryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Entry
{

    /**
     * @ORM\PrePersist
     */
    public function onPrePersistLifecycle()
    {
        $this->creationDate = new \DateTime();
        $this->ip = $_SERVER['REMOTE_ADDR'];
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
     * @ORM\ManyToOne(targetEntity="Form", inversedBy="entries")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id")
     */
    private $form;




    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=45)
     */
    private $ip;

    /**
     * @var array
     *
     * @ORM\Column(name="form_data", type="json_array")
     */
    private $formData;


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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Entry
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Entry
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    
        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set formData
     *
     * @param array $formData
     * @return Entry
     */
    public function setFormData($formData)
    {
        $this->formData = $formData;
    
        return $this;
    }

    /**
     * Get formData
     *
     * @return array 
     */
    public function getFormData()
    {
        return $this->formData;
    }

    /**
     * Set form
     *
     * @param \Webbb\Bundle\FormBundle\Entity\Form $form
     * @return Entry
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
}