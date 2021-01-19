<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{
    /**
     *
     * @var PropertyRepository $propertyRepository
     */
    private $propertyRepository;



  public function __construct(PropertyRepository $propertyRepository)
  {
      $this->propertyRepository = $propertyRepository;
  }


    /**
     * @Route("/biens", name="property.index")
     */
    public function index() : Response
    {
    
        // $property = new Property();
        // $property->setTitle("Mon premier bien")
        //         ->setPrice(200000)
        //         ->setRooms(4)
        //         ->setBedrooms(3)
        //         ->setDescription('Une petite description')
        //         ->setSurface(60)
        //         ->setFloor(4)
        //         ->setHeat(1)
        //         ->setCity("Monpellier")
        //         ->setAddress("15 Boulevard Gambeta")
        //         ->setPostalCode('384000');
        //       $em =  $this->getDoctrine()->getManager();
        //       $em->persist($property);
        //       $em->flush();
        $property = $this->propertyRepository->find(1);
       // dd($property);

          return $this->render('property/index.html.twig', [
            "current_menu" => "properties"
           
            
            

        ]);
    }

    /**
    * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     * 
     */
    public function show(Property $property, string $slug): Response
    {
        // if($property->getSlug() === $slug){
        //   return  $this->redirectToRoute('property.show', [
        //         'id' => $property->getId(),
        //         "slug" => $property->getSlug()
        //     ], 301);
        //}
       // $property = $this->propertyRepository->find($id);
     
        return $this->render('property/show.html.twig', [
            'property' => $property,
            "current_menu" => "properties"
           
        ]);    
    }
}



