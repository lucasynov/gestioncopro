<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Activite;
use AppBundle\Entity\Conversation;
use AppBundle\Entity\Message;
use AppBundle\Entity\Projet;
use AppBundle\Entity\ReponseSondage;
use AppBundle\Entity\Sondage;
use AppBundle\Service\CheckDroit;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
/**
 * Projet controller.
 *
 * @Route("")
 */
class ProjetController extends Controller
{
    /**
     * Lists all projet entities.
     *
     * @Route("/projets", name="projet_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $projetRepository = $this->get('doctrine')->getRepository('AppBundle:Projet');
        $projets = $projetRepository->findAll();
        
        return $this->render('projet/index.html.twig', array(
            'projets' => $projets,
        ));
    }
    
    
    
    /**
     * Creates a new projet entity.
     *
     * @Route("/new", name="projet_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $projet = new Projet();
        $form = $this->createForm('AppBundle\Form\ProjetType', $projet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           
            //Pour la gestion des mails mais je crois que ca ne marche pas en local
            //
//            foreach($projet->getPersonnesConcernees() as $proprietaire){
//                $proprietaire->addProjet($projet);
//                $proprietaire->addConversation($conversation);
//                if ($proprietaire != $this->getUser()->getIdProprietaire()) {
//                    if ($proprietaire->getUser()->getEmail() != null) {
//                        $message = \Swift_Message::newInstance()
//                            ->setSubject("Notification : modification " . $projet->getNom())
//                            ->setFrom('noreply@yopmail.com')
//                            ->setTo($proprietaire->getUser()->getEmail())
//                            ->setBody("Madame, Monsieur, " . $this->getUser()->getIdProprietaire() . " viens de créer un projet "  . $projet->getNom() . " concernant la co-propriété et vous concernant également. Cordialement");
//                        $this->get('mailer')->send($message);
//                    }
//                }
//            }
            
            
            if($projet->getFilDiscussion() == true){
                $UserRepository = $this->get('doctrine')->getRepository('AppBundle:User');
                $ConversUserRepo = $this->get('doctrine')->getRepository('AppBundle:ConversationUser');
                $users = $UserRepository->findAll();
                
                $conversation = new Conversation();
                $conversation->setName('Conversation Projet '.$projet->getNom());
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($conversation);
                $em->flush();
                $id_conversation = $conversation->getId();
                
                foreach($users as $key => $user){
                    $ConversUserRepo->insertConversationUser($user->getId(),$id_conversation);
                }
                $projet->setFilDiscussion($conversation);
            }else{
                $projet->setFilDiscussion(null);
            }
            
            $projet->setStatut('En discussion');
            $em = $this->getDoctrine()->getManager();
            $em->persist($projet);
            $em->flush();
            return $this->redirectToRoute('projet_show', array('id' => $projet->getId()));
        }
        return $this->render('projet/new.html.twig', array(
            'projet' => $projet,
            'form' => $form->createView(),
        ));
    }
    
    
    /**
     * Finds and displays a projet entity.
     *
     * @Route("/projectsAddConvers/{id}", name="addProjetConversation")
     * @Method({"GET", "POST"})
     */
    public function addProjetConversation(Request $request, Projet $projet){
        
        $UserRepository = $this->get('doctrine')->getRepository('AppBundle:User');
        $ConversUserRepo = $this->get('doctrine')->getRepository('AppBundle:ConversationUser');
        $users = $UserRepository->findAll();

        $conversation = new Conversation();
        $conversation->setName('Conversation Projet '.$projet->getNom());

        $em = $this->getDoctrine()->getManager();
        $em->persist($conversation);
        $em->flush();
        $id_conversation = $conversation->getId();

        foreach($users as $key => $user){
            $ConversUserRepo->insertConversationUser($user->getId(),$id_conversation);
        }
        $projet->setFilDiscussion($conversation);
            

        $em = $this->getDoctrine()->getManager();
        $em->persist($projet);
        $em->flush();
        
        return $this->redirectToRoute('projet_show', array('id' => $projet->getId()));
    }

    
    /**
     *
     * @Route("/addProjetPj/{id}", name="addProjetPj")
     * @Method({"GET", "POST"})
     */
    public function addProjetPj(Request $request, Projet $projet){
        dump($projet);die;
        
    }
    
    
    /**
     *
     * @Route("/deleteProjetPj/{id}", name="deletePieceJointeProjet")
     * @Method({"GET", "POST"})
     */
    public function deletePieceJointeProjet(Request $request, Projet $projet){
        dump($projet);die;
    }
    
    
    
    
    /**
     * Finds and displays a projet entity.
     *
     * @Route("/projects/{id}", name="projet_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, Projet $projet)
    {      
        $conversation = null;
        $ConversationRepository = $this->get('doctrine')->getRepository('AppBundle:Conversation');
        
        if($projet->getFilDiscussion() != null){
            $conversation = $ConversationRepository->findOneBy(['id' => $projet->getFilDiscussion()->getId()]);
        }
        
        return $this->render('projet/show.html.twig', array(
            'projet' => $projet,
            'conversation' => $conversation,
        ));
    }
    

    /**
     * Displays a form to edit an existing projet entity.
     *
     * @Route("/{id}/edit", name="projet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Projet $projet)
    {
        $editForm = $this->createFormBuilder($projet)->add('description')->add('statut', ChoiceType::class, array(
            'choices'  => array(
                'En discussion' => 'En discussion',
                'En attente d\'éxécution' => 'En attente d execution',
                'Exécuté' => 'Execute',
            ),
        ))->getForm();
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();           
            
            return $this->redirectToRoute('projet_show', array('id' => $projet->getId()));
        }
        return $this->render('projet/edit.html.twig', array(
            'projet' => $projet,
            'edit_form' => $editForm->createView(),
        ));
    }
    
    
    
    /**
     * Deletes a projet entity.
     *
     * @Route("/delete/{id}", name="projet_delete")
     */
    public function deleteAction(Request $request, Projet $projet)
    {
        $projet->setPersonnesConcernees(null);
        $projet->setListeSondage(null);
     
        $em = $this->getDoctrine()->getManager();
        $em->remove($projet);
        $em->flush();

        return $this->redirectToRoute('projet_index');
    }
    
}