<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Entity\Reunion;
use AppBundle\Repository\ReunionRepository;


class ReunionController extends Controller
{
   
    
     /**
     * @Route("/reunion", name="AddReunion")
     */
    public function createAction()
    {
        if(isset($_POST) && $_POST != []){

            try{
                $em = $this->getDoctrine()->getManager();

                $date = $_POST['date'];
                if(date_create_from_format('Y-m-d H:i:s',$date) != true){
                    return $this->render('/reunion/addReu.html.twig', array(
                        'messageFalse' => 'La date est mal formatée',
                    ));
                }else{
                    $date_format = date_create_from_format('Y-m-d H:i:s',$date);
                }
               
                $name = $_POST['name'];
                $user = $this->getUser();
                $username = $user->getUsername();

                $reunion = new Reunion();
                $reunion->setName($name);
                $reunion->setDate($date_format);
                $reunion->setOrganisateur($username);
                $reunion->setId();

                $em->persist($reunion);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Votre réunion a bien été enregistré !!'
                );

                return $this->redirectToRoute('reunions');


            }catch(Exception $e){

                return $this->render('/reunion/addReu.html.twig', array(
                    'messageFalse' => 'Un problème est survenu',
                ));
            }
        }

        return $this->render('/reunion/addReu.html.twig', array(
           
        ));
    }


}