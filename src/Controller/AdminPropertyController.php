<?php
namespace App\Controller;

use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;

use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminPropertyController extends AbstractController {

    private $propertyRepository;
    


 public function __construct(PropertyRepository $propertyRepository)
      {
          $this->propertyRepository = $propertyRepository;
          

      }

/**
 * @Route("/admin", name="admin.property.index")
 *
 */
    public function index()
    {
     $properties =  $this->propertyRepository->findAll();
     return $this->render('admin/index.html.twig', compact('properties'));
    }

     /**
     * @Route("/admin/create", name="admin.property.new")
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class,   $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($property);
            $entityManager->flush();
            $this->addFlash("success", "Bien crée avec succés");
            return $this->redirectToRoute('admin.property.index');

        }
        return $this->render('/admin/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
       }

    

    /**
     * @Route("/admin/{id}", name="admin.property.edit",  methods="GET|POST")
     *
     * 
     */
    public function edit(Property $property, Request $request)
    {
    
        //$option = new Option();
        //$property->addOption($option);

    $form = $this->createForm(PropertyType::class, $property);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $this->addFlash("success", "Bien modifié avec succés");
        return $this->redirectToRoute('admin.property.index');

    }

     return $this->render('admin/edit.html.twig', [
         'property' => $property,
         'form' => $form->createView()
     ]);
    }
      /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * 
     */
    public function delete(Property $property, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))){
              $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($property);
                $entityManager->flush();
                $this->addFlash("success", "Bien supprimé avec succés");
               // return new Response('Suppression');

      
        }
       
        return $this->redirectToRoute('admin.property.index');
    }
}