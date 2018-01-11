<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CompteType;

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
    
    
    
     /**
     * @Route("/addPieceJointeCr/", name="addPieceJointeCr")
     */
    public function addPieceJointeCr(Request $request)
    {
        $id_reunion = $request->query->get('id_reunion');
        $reunionRepository = $this->get('doctrine')->getRepository('AppBundle:Reunion');

        $reunion = $reunionRepository->findOneBy(['id' => $id_reunion]);

        $form = $this->createForm(CompteType::class, $reunion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            
            $file = $reunion->getCompteRendu();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();          
            
            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('compteRendu_directory'),
                $fileName
            );
            
            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $reunion->setCompteRendu($fileName);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($reunion);
            $em->flush();

            return $this->redirectToRoute('reunions');
        }
       
       
        return $this->render('reunion/addPj.html.twig', array(
            'form' => $form->createView(),
        ));
        
    }
    
    
     /**
     * @Route("/deletePjCr/", name="deletePieceJointeCr")
     */
    public function deletePieceJointeCr(Request $request){
        
        $id_reunion = $request->query->get('id_reunion');     
        $reunionRepository = $this->get('doctrine')->getRepository('AppBundle:Reunion');
        $reunion = $reunionRepository->findOneBy(['id' => $id_reunion]);
        $reunion->setCompteRendu(null);
        
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($reunion);
        $em->flush();
        
        $this->addFlash(
            'notice',
            'La piece jointe a été supprimée !!'
        );
        
        return $this->redirectToRoute('reunions');
    }


}