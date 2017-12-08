<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message 
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="integer")
     */
    private $idUser;

     /**
     * @ORM\Column(type="integer")
     */
    private $id_conversation;





    public function __construct()
    {
       
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date;
    } 

    public function getMessage()
    {
        return $this->message;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function getIdConversation()
    {
        return $this->id_conversation;
    }



    /**
     * Set date
     *
     * @param datetime $date
     *
     * @return Message
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }


    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Message
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Set idConversation
     *
     * @param integer $id_conversation
     *
     * @return Message
     */
    public function setIdConversation($id_conversation)
    {
        $this->id_conversation = $id_conversation;

        return $this;
    }



    /**
     * Set name
     *
     * @param text $message
     *
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }


}