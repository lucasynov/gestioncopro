<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Charge;
use AppBundle\Entity\Versement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\FileVersementType;

/**
 * Versement controller.
 *
 * @Route("/versement")
 */
class VersementController extends Controller
{
    /**
     * Lists all versement entities.
     *
     * @Route("/", name="versement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $versements = $em->getRepository('AppBundle:Versement')->findAll();
        return $this->render('versement/index.html.twig', array(
            'versements' => $versements,
        ));
    }
    
    
    /**
     * Creates a new versement entity.
     *
     * @Route("/new", name="versement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $versement = new Versement();
        $form = $this->createForm('AppBundle\Form\VersementType', $versement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $versement->setProprietaire($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($versement);
            $em->flush();
            return $this->redirectToRoute('versement_index');
        }
        return $this->render('versement/new.html.twig', array(
            'versement' => $versement,
            'form' => $form->createView(),
        ));
    }
    
    
    
    
    /**
     * Finds and displays a versement entity.
     *
     * @Route("/{id}", name="versement_show")
     * @Method("GET")
     */
    public function showAction(Versement $versement)
    {
        $deleteForm = $this->createDeleteForm($versement);
        return $this->render('versement/show.html.twig', array(
            'versement' => $versement,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    
    
    
    /**
     * Displays a form to edit an existing versement entity.
     *
     * @Route("/{id}/edit", name="versement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Versement $versement)
    {
        $deleteForm = $this->createDeleteForm($versement);
        $editForm = $this->createForm('AppBundle\Form\VersementType', $versement);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('versement_index', array('id' => $versement->getId()));
        }
        return $this->render('versement/edit.html.twig', array(
            'versement' => $versement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    
    
    
    /**
     * Deletes a versement entity.
     *
     * @Route("/{id}", name="versement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Versement $versement)
    {
        $form = $this->createDeleteForm($versement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($versement);
            $em->flush();
        }
        return $this->redirectToRoute('versement_index');
    }


    /**
     * Creates a form to delete a versement entity.
     *
     * @param Versement $versement The versement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Versement $versement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('versement_delete', array('id' => $versement->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
    
    
    
    
    /**
     * @Route("/addPieceJointeVersement/{id}", name="addPieceJointeVersement")
     */
    public function addPieceJointeVersement(Request $request, Versement $versement)
    {
        
        $form = $this->createForm(FileVersementType::class, $versement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $versement->getPiecesJointes();


            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();          

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('pieceJointeVersement_directory'),
                $fileName
            );
            
            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $versement->setpiecesJointes($fileName);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($versement);
            $em->flush();

            return $this->redirectToRoute('versement_index');
        }
       
        
        return $this->render('versement/addPj.html.twig', array(
            'form' => $form->createView(),
        ));
        
    }
    
    
     /**
     * @Route("/deletePieceJointeVersement/{id}", name="deletePieceJointeVersement")
     */
    public function deletePieceJointeVersement(Request $request, Versement $versement){
       
        
        $versement->setpiecesJointes(null);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($versement);
        $em->flush();
        
        $this->addFlash(
            'notice',
            'La piece jointe a été supprimée !!'
        );
        
        return $this->redirectToRoute('versement_index');
    }
    
}