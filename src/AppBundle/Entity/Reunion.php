<?php


namespace AppBundle\Entity;




use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @ORM\Column(name="compteRendu", type="string" ,nullable=true)
     * 
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $compteRendu;
    
    
     /**
     * @ORM\Column(name="lieu", type="string" ,nullable=true)
     * 
     */
    private $lieu;

    
    function getLieu() {
        return $this->lieu;
    }

    function setLieu($lieu) {
        $this->lieu = $lieu;
    }

        function getCompteRendu() {
        return $this->compteRendu;
    }

    function setCompteRendu($compteRendu) {
        $this->compteRendu = $compteRendu;
    }

    
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