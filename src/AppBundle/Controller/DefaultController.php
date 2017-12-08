<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;


class DefaultController extends Controller
{
    
    public function createAction()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: createAction(EntityManagerInterface $em)
        $em = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName('ReyNal');
        $product->setPrice(10000000.00);
        $product->setDescription('BG');

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('Saved new product with id '.$product->getId());
    }



    // if you have multiple entity managers, use the registry to fetch them
    public function editAction()
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $em2 = $doctrine->getManager('other_connection');
    }


    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(){

        $UserRepository = $this->get('doctrine')->getRepository('AppBundle:User');
        $ReunionRepository = $this->get('doctrine')->getRepository('AppBundle:Reunion');
        $ConversationUserRepository = $this->get('doctrine')->getRepository('AppBundle:ConversationUser');

        $user = $this->getUser();
        $username = $user->getUsername();
        $email = $user->getEmail();
        $idUser = $user->getId();



        $reunions = $ReunionRepository->findAll();
        $users = $UserRepository->findAll();
        $conversationUsers = $ConversationUserRepository->getOurConversation($idUser);   
       
        return $this->render('index/index.html.twig', array(
            'username' => $username,
            'email' => $email,
            'users' => $users,
            'reunions' => $reunions,
            'conversationUsers' => $conversationUsers,
        ));
    }




    public function showAction()
    {
        $productId = $_GET['id'];
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($productId);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$productId
            );
        }

        // ... do something, like pass the $product object into a template

        return new Response(var_dump($product));
    }
}