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
            ->add('montant', NumberType::class)
            ->add('dateEcheance', DateType::class, array('label' => "Date d'échéance"))
            ->add('statut', CheckboxType::class, array('label' => 'Payé', 'required' => false))
            ->getForm();


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){ 
   			$charge->setstatut(0);
  			$charge->setcoproprietaires('Tous');
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
     * @Route("/archiveCharge/", name="archiveCharge")
     */
    public function archiveCharge(Request $request)
    {
        $id_charge = $_GET['id_charge'];
        
        
        $ChargesRepository = $this->get('doctrine')->getRepository('AppBundle:Charges');
        $charge = new Charges();
        $charge = $ChargesRepository->findOneBy(['id' => $id_charge]);

        $em = $this->getDoctrine()->getManager();
        $em->remove($charge);
        $em->flush();

        $this->addFlash(
            'notice',
            'La charge a été archivée !'
        );

        return $this->redirectToRoute('charges');
    }
}