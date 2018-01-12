<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;





/**
 * Projet
 *
 * @ORM\Table(name="projet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjetRepository")
 */
class Projet
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=100, columnDefinition="ENUM('En discussion', 'En attente d execution', 'Execute')")
     */
    private $statut;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOuverture", type="date")
     */
    private $dateOuverture;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCloture", type="date", nullable=true)
     */
    private $dateCloture;
    
    
    /**
     * @ORM\OneToOne(targetEntity="Conversation", cascade={"all"})
     * @ORM\JoinColumn(name="discussion_id", referencedColumnName="id", nullable=true)
     */
    private $filDiscussion;
    
    
    /**
     * @ORM\OneToMany(targetEntity="Sondage", mappedBy="idProjet", cascade={"all"})
     */
    private $listeSondage;
    
    
    /**
     * @ORM\Column(name="piece_jointe", type="string", nullable=true)
     *
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $piecesJointes;
    
    
    
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $proprietaire;
    
    
    
    
    /**
     * @ORM\ManyToMany(targetEntity="User" , mappedBy="projets")
     */
    private $personnesConcernees;
    
    
   

    public function addPropietaire(Proprietaire $proprietaire)
    {
        $this->personnesConcernees[] = $proprietaire;
    }
    public function __toString()
    {
        return $this->getNom();
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    /**
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }
    /**
     * @param string $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }
    /**
     * @return \DateTime
     */
    public function getDateOuverture()
    {
        return $this->dateOuverture;
    }
    /**
     * @param \DateTime $dateOuverture
     */
    public function setDateOuverture($dateOuverture)
    {
        $this->dateOuverture = $dateOuverture;
    }
    /**
     * @return \DateTime
     */
    public function getDateCloture()
    {
        return $this->dateCloture;
    }
    /**
     * @param \DateTime $dateCloture
     */
    public function setDateCloture($dateCloture)
    {
        $this->dateCloture = $dateCloture;
    }
    /**
     * @return mixed
     */
    public function getFilDiscussion()
    {
        return $this->filDiscussion;
    }
    /**
     * @param mixed $filDiscussion
     */
    public function setFilDiscussion($filDiscussion)
    {
        $this->filDiscussion = $filDiscussion;
    }
    /**
     * @return mixed
     */
    public function getListeSondage()
    {
        return $this->listeSondage;
    }
    /**
     * @param mixed $listeSondage
     */
    public function setListeSondage($listeSondage)
    {
        $this->listeSondage = $listeSondage;
    }
    /**
     * @return mixed
     */
    public function getPiecesJointes()
    {
        return $this->piecesJointes;
    }
    /**
     * @param mixed $piecesJointes
     */
    public function setPiecesJointes($piecesJointes)
    {
        $this->piecesJointes = $piecesJointes;
    }
    /**
     * @return mixed
     */
    public function getProprietaire()
    {
        return $this->proprietaire;
    }
    /**
     * @param mixed $proprietaire
     */
    public function setProprietaire($proprietaire)
    {
        $this->proprietaire = $proprietaire;
    }
    /**
     * @return mixed
     */
    public function getPersonnesConcernees()
    {
        return $this->personnesConcernees;
    }
    /**
     * @param mixed $personnesConcernees
     */
    public function setPersonnesConcernees($personnesConcernees)
    {
        $this->personnesConcernees = $personnesConcernees;
    }
}