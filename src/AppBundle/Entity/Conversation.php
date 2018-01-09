<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_conversation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConversationRepository")
 */
class Conversation 
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;


    /**
     * @var int
     *
     */
    private $copropritaires;
    
    
    
    

    public function __construct()
    {
       
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }



    /**
     * Set name
     *
     * @param string $name
     *
     * @return Reunion
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * Set id
     *
     * @param string $id
     *
     * @return Reunion
     */
    public function setId()
    {
        $this->id = '';

        return $this;
    }


}