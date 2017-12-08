<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user_conversation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConversationUserRepository")
 */
class ConversationUser 
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idUser;

    /**
     * @ORM\Column(type="integer")
     */
    private $idConversation;


    public function __construct()
    {
       
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdConversation()
    {
        return $this->idConversation;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }




    /**
     * Set idConversation
     *
     * @param integer $idConversation
     *
     * @return ConversationUser
     */
    public function setIdConversation($idConversation)
    {
        $this->idConversation = $idConversation;

        return $this;
    }


    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return ConversationUser
     */
    public function setId($idUser)
    {
        $this->id = $idUser;

        return $this;
    }


}