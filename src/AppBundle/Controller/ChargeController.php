<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Charges;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;



use AppBundle\Repository\ChargesRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AppBundle\Form\FileType;


class ChargeController extends Controller
{
    /**
     * @Route("/AddCharge", name="AddCharge")
     */
    public function createAction(Request $request)
    {
    	$charge = new Charges();

        $form = $this->createFormBuilder($charge)
            ->add('titre', TextType::class)
            ->add('copropritaires', EntityType::class, array(
                'class' => User::class,
                'choice_label' => 'username',
                'multiple' => true,
            ))
            ->add('montant', NumberType::class)
            ->add('dateEcheance', DateType::class, array('label' => "Date d'échéance"))
            ->add('statut', CheckboxType::class, array('label' => 'Payé', 'required' => false))
            ->getForm();

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){        
            $charge->setstatut(0);
            $charge->setcopropritaires($charge->getcopropritaires());
   
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($charge);
            $em->flush();


          $this->addFlash(
                'notice',
                'La nouvelle charge a bien été enregistré !!'
            );

            return $this->redirectToRoute('charges');
        }


        return $this->render('charges/addCharges.html.twig', array(
            'form' => $form->createView(),
        ));   
    }
    
   
    
    
    
    
    /**
     * @Route("/addPieceJointe/", name="addPieceJointe")
     */
    public function addPieceJointe(Request $request)
    {
        $id_charge = $request->query->get('id_charge');
        
        $ChargesRepository = $this->get('doctrine')->getRepository('AppBundle:Charges');

        $charge = new Charges();
        $charge = $ChargesRepository->findOneBy(['id' => $id_charge]);
        
        $form = $this->createForm(FileType::class, $charge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $charge->getpiecejointe();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();          
            
            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('pieceJointes_directory'),
                $fileName
            );
            
            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $charge->setCompteRendu($fileName);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($charge);
            $em->flush();

            return $this->redirectToRoute('charges');
        }
       
        
        return $this->render('charges/addPj.html.twig', array(
            'form' => $form->createView(),
        ));
        
    }
    
    
     /**
     * @Route("/deletePj/", name="deletePieceJointe")
     */
    public function deletePieceJointe(Request $request){
        $id_charge = $request->query->get('id_charge');
        $ChargesRepository = $this->get('doctrine')->getRepository('AppBundle:Charges');
        $charge = $ChargesRepository->findOneBy(['id' => $id_charge]);
        $charge->setpieceJointe(null);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($charge);
        $em->flush();
        
        $this->addFlash(
            'notice',
            'La piece jointe a été supprimée !!'
        );
        
        return $this->redirectToRoute('charges');
    }
    
    
    
    
    
    /**
     * @Route("/archiveCharge/", name="archiveCharge")
     */
    public function archiveCharge(Request $request)
    {
        $id_charge = $request->query->get('id_charge');
        
        
        $ChargesRepository = $this->get('doctrine')->getRepository('AppBundle:Charges');
        $charge = new Charges();
        $charge = $ChargesRepository->findOneBy(['id' => $id_charge]);

        $em = $this->getDoctrine()->getManager();
        $em->remove($charge);
        $em->flush();

        $this->addFlash(
            'notice',
            'La charge a été archivée !!'
        );

        return $this->redirectToRoute('charges');
    }
}