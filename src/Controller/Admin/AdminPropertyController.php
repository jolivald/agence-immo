<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class AdminPropertyController extends AbstractController {

  /**
   * @var PropertyRepository $repository
   */
  private $repository;

  /**
   * @var EntityManagerInterface $em
   */
  private $em;

  public function __construct(PropertyRepository $repository, EntityManagerInterface $em) {
    $this->repository = $repository;
    $this->em = $em;
  }

  /**
   * @Route("/admin/property", name="admin.property.index")
   */
  public function index() {
    $properties = $this->repository->findAll();
    return $this->render('admin/property/index.html.twig', [
      'current_menu' => 'admin',
      'properties' => $properties
    ]);
  }

  /**
   * @Route("/admin/property/create", name="admin.property.create")
   */
  public function create(Request $request) {
    $property = new Property();
    $form = $this->createForm(PropertyType::class, $property);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
      $this->em->persist($property);
      $this->em->flush();
      return $this->redirectToRoute('admin.property.index');
    }
    return $this->render('admin/property/create.html.twig', [
      'property' => $property,
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/admin/property/{id}", name="admin.property.edit", methods={"GET", "POST"})
   */
  public function edit($id, Request $request/*, CacheManager $cache, UploaderHelper $helper*/) {
    $property = $this->repository->find($id);
    $form = $this->createForm(PropertyType::class, $property);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
      /*if ($property->getImageFile() instanceof UploadedFile){
        $cache->remove($helper->asset($property, 'imageFile'));
      }*/
      $this->em->flush();
      $this->addFlash('success', 'Bien modifié avec succès');
      return $this->redirectToRoute('admin.property.index');
    }
    return $this->render('admin/property/edit.html.twig', [
      'current_menu' => 'admin',
      'property' => $property,
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/admin/property/{id}", name="admin.property.delete", methods={"DELETE"})
   */
  public function delete($id, Request $request) {
    $property = $this->repository->find($id);
    if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token'))){
      $this->em->remove($property);
      $this->em->flush();
      $this->addFlash('success', 'Bien supprimé avec succès');
    }
    return $this->redirectToRoute('admin.property.index');
  }

}