<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
  /**
   * @Route("/product", name="create_product")
   */
  public function createProduct(): Response
  {
    $product = new Product();
    $product->setName('Keyboard');
    $product->setPrice(1999);
    $product->setDescription('Ergonomic and stylish!');

    // you can fetch the EntityManager via $this->getDoctrine()
    // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
    $entityManager = $this->getDoctrine()->getManager();

    // tell Doctrine you want to (eventually) save the Product (no queries yet)
    $entityManager->persist($product);

    // actually executes the queries (i.e. the INSERT query)
    $entityManager->flush();

    return new Response('Saved new product with id ' . $product->getId());
  }



  /**
   * @Route("/product/todos", name="product_show_all")
   */
  public function showAll(): Response
  {
    $products = $this->getDoctrine()
      ->getRepository(Product::class)
      ->findAll();

    if (!$products) {
      throw $this->createNotFoundException(
        'No product found'
      );
    }

    return $this->render('product/show_all.html.twig', [
      'titulo' => 'Produtos disponíveis:',
      'products' => $products
    ]);
  }

  /**
   * @Route("/product/{id}", name="product_show_id")
   */
  public function show_id($id): Response
  {
    $product = $this->getDoctrine()
      ->getRepository(Product::class)
      ->find($id);

    if (!$product) {
      throw $this->createNotFoundException(
        'No product found'
      );
    }

    return $this->render('product/show_edit.html.twig', [
      'pId' => $product->getId(),
      'pName' => $product->getName(),
      'pPrice' => $product->getPrice(),
      'pDescription' => $product->getDescription(),
    ]);
  }


  /**
   * @Route("/product/edit", name="edit")
   */
  public function edit(Request $r): Response
  {
    $entityManager = $this->getDoctrine()->getManager();
    $product = $entityManager
      ->getRepository(Product::class)
      ->find($r->request->get('id'));


    if (!$product) {
      throw $this->createNotFoundException(
        'No product found for id '
      );
    }


    $product->setName($r->request->get('name'));
    $product->setName($r->request->get('price'));
    $product->setName($r->request->get('description'));


    $entityManager->flush();


    return $this->redirectToRoute('product/', [
      'id' => $product->getId()
    ]);
  }
}
