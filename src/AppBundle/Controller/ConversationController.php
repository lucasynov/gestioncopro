<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Entity\Conversation;
use AppBundle\Repository\ConversationRepository;

use AppBundle\Entity\Message;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class ConversationController extends Controller
{
   
    
     /**
     * @Route("/conversation", name="showConversation")
     */
    public function showAction(Request $request)
    {
        $id_conversation = $_GET['id_conversation'];
        $user = $this->getUser();
        $idUser = $user->getId();

        $message = new Message();

        $form = $this->createFormBuilder($message)
            ->add('message', TextType::class)
            ->getForm();


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){ 
            $date_now = date("Y-m-d H:i:s");
            $date = date_create_from_format('Y-m-d H:i:s', $date_now);
            $message = $form->getData();
            $message->setDate($date);
            $message->setIdConversation(intval($id_conversation));
            $message->setIdUser($idUser);

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
        }

    

    	$MessageRepository = $this->get('doctrine')->getRepository('AppBundle:Message');
        $ConversationRepository = $this->get('doctrine')->getRepository('AppBundle:Conversation');
        $UserRepository = $this->get('doctrine')->getRepository('AppBundle:User');

        $messages = $MessageRepository->findBy(['id_conversation' => $id_conversation], array('date' => 'asc'));

        $conversation = $ConversationRepository->findBy(['id' => $id_conversation]);

        $name = $conversation[0]->getName();

        foreach ($messages as $key => $message) {
            $id_user_message = $message->getIdUser();
            $user = $UserRepository->findOneBy(['id' => $id_user_message]);
            $message->username = $user->getUsername();
        }
        

        return $this->render('conversation/index.html.twig', array(
            'messages' => $messages,
            'idUser' => $idUser,
            'name' => $name,
            'form' => $form->createView(),
        ));    
    }






    /**
     * @Route("/archiveConversation/", name="archiveConversation")
     */
    public function archiveConversation(Request $request)
    {
        $id_conversation = $_GET['id_conversation'];
        $ConversationRepository = $this->get('doctrine')->getRepository('AppBundle:Conversation');
        $conversation = new Conversation();
        $conversation = $ConversationRepository->findOneBy(['id' => $id_conversation]);
        
        $ProjetRepository = $this->get('doctrine')->getRepository('AppBundle:Projet');
        $projet = $ProjetRepository->findOneBy(['filDiscussion' => $id_conversation]);

        if($projet != null){
            $projet->setFilDiscussion(null);
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($conversation);
        $em->flush();

        $this->addFlash(
            'notice',
            'La conversation a été archivée'
        );

        return $this->redirectToRoute('conversations');
    }





    /**
     * @Route("/conversation_new/", name="AddConversation")
     */
    public function AddConversation(Request $request)
    {

        $conversation = new Conversation();

        $form = $this->createFormBuilder($conversation)
            ->add('name', TextType::class, array('label' => 'Nom de la conversation :'))
            ->getForm();
        
        $UserRepository = $this->get('doctrine')->getRepository('AppBundle:User');
        $ConversUserRepo = $this->get('doctrine')->getRepository('AppBundle:ConversationUser');
        $users = $UserRepository->findAll();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){ 

            $em = $this->getDoctrine()->getManager();
            $em->persist($conversation);
            $em->flush();
            $id_conversation = $conversation->getId();

            
            if($_POST != []){
                if(isset($_POST['check_list']) && $_POST['check_list'] != []){
                    foreach($_POST['check_list'] as $key => $idUser){
                        $ConversUserRepo->insertConversationUser($idUser,$id_conversation);
                    }            
                }else{
                    foreach($users as $key => $User){
                        $ConversUserRepo->insertConversationUser($User->getId(),$id_conversation);
                    } 
                }
            }

            
            return $this->redirectToRoute('conversations');

        }



        return $this->render('conversation/add.html.twig', array(
            'users' => $users,
            'form' => $form->createView(),
        ));    



    }


}