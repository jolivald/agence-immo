<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository $repository
     */
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/property", name="property.index")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('property/index.html.twig', [
            'current_name' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/property/{slug}-{id}", name="property.show", requirements={ "slug": "[a-z0-9\-]*" })
     */
    public function show($slug, $id, Request $request, ContactNotification $notification): Response {
        $property = $this->repository->find($id);
        if ($property->getSlug() !== $slug){
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $notification->notify($contact);
            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ]);
        }
        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
}
