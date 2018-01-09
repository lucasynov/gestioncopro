<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AppCharges
 *
 * @ORM\Table(name="app_charges")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChargesRepository")
 */
class Charges
{
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=100, nullable=false)
     */
    private $titre;


    /**
     * @var string
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_echeance", type="date", nullable=false)
     */
    private $dateEcheance;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=false)
     */
    private $statut;

    /**
     * @var int
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="charges",  cascade={"persist"})
     */
    private $copropritaires;

    
    
    
    /**
     * @ORM\Column(name="piece_jointe", type="string", nullable=true)
     *
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $pieceJointe;

    
    
    
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id_contrat", type="integer", nullable=true)
     */
    private $idContrat;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
        
    
    
    public function __construct() {
        $this->copropritaires = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    
    
    public function getId(){
        return $this->id;
    }



    public function getTitre()
    {
        return $this->titre;
    }
    
    
    



    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Charges
     */
    public function settitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }




    public function getMontant()
    {
        return $this->montant;
    }



    /**
     * Set montant
     *
     * @param string $montant
     *
     * @return Charges
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }




    public function getcopropritaires()
    {
        return $this->copropritaires;
    }



    /**
     * Set copropritaires
     *
     * @param User $copropritaires
     *
     * @return Charges
     */
    public function setcopropritaires($copropritaires)
    {
        $this->copropritaires = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($copropritaires as $copropritaire) {
            $copropritaire->addCharge($this);
            $this->addCoproprietaire($copropritaire);
        }

        return $this;
    }

    public function addCoproprietaire($coproprietaire)
    {
        $this->copropritaires->add($coproprietaire);
    }

    public function removeCoproprietaire($coproprietaire)
    {
        $this->copropritaires->remove($coproprietaire);
    }

    public function getstatut()
    {
        return $this->statut;
    }



    /**
     * Set statut
     *
     * @param integer $statut
     *
     * @return Charges
     */
    public function setstatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }





    public function getpiecejointe()
    {
        return $this->pieceJointe;
    }



    /**
     * Set pieceJointe
     *
     * @param string $pieceJointe
     *
     * @return Charges
     */
    public function setpieceJointe($pieceJointe)
    {
        $this->pieceJointe = $pieceJointe;

        return $this;
    }



    public function getidcontrat()
    {
        return $this->idContrat;
    }



    /**
     * Set idContrat
     *
     * @param string $idContrat
     *
     * @return Charges
     */
    public function setidContrat($idContrat)
    {
        $this->idContrat = $idContrat;

        return $this;
    }



     public function getdateEcheance()
    {
        return $this->dateEcheance;
    }



    /**
     * Set dateEcheance
     *
     * @param datetime $dateEcheance
     *
     * @return Charges
     */
    public function setdateEcheance($dateEcheance)
    {
        $this->dateEcheance = $dateEcheance;

        return $this;
    }
}

