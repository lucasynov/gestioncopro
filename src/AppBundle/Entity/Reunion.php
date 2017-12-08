<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_reunion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReunionRepository")
 */
class Reunion 
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
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $organisateur;

    /**
     * @ORM\Column(name="compte_rendu", type="string", length=100)
     */
    private $compte_rendu;




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

    public function getName()
    {
        return $this->name;
    }

    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    public function getCompte_Rendu()
    {
        return $this->compte_rendu;
    }



    /**
     * Set date
     *
     * @param datetime $date
     *
     * @return Reunion
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
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
     * Set organisateur
     *
     * @param string $organisateur
     *
     * @return Reunion
     */
    public function setOrganisateur($organisateur)
    {
        $this->organisateur = $organisateur;

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