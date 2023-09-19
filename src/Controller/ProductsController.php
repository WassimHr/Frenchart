<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/products', name: 'products_')]

class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]

    public function index(): Response
    {
        return $this->render('products/index.html.twig');
    }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {

        $product = new Products();
        $productForm = $this->createForm(ProductsFormType::class, $product);
        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $slug = $product->getName();
            $product->setSlug($slug);

            $prix = $product->getPrice() * 100;
            $product->setPrice($prix);

            $product->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($product);
            $manager->flush();

            $this->addFlash('success', 'Produit ajouté avec succès !');

            return $this->redirectToRoute('main');
        }

        return $this->render('products/add.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }

    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Request $request, EntityManagerInterface $manager, Products $product): Response
    {

        $prix= $product->getPrice()/100;
        $product->setPrice($prix);

        $productForm = $this->createForm(ProductsFormType::class, $product);
        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $slug = $product->getName();
            $product->setSlug($slug);

            $prix = $product->getPrice() * 100;
            $product->setPrice($prix);

            $product->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($product);
            $manager->flush();

            $this->addFlash('success', 'Produit ajouté avec succès !');

            return $this->redirectToRoute('main');
        }

        return $this->render('products/edit.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }

    #[Route('/{slug}', name: 'details')]
    public function details(Products $product): Response
    {
        return $this->render('products/details.html.twig', [
            'product' => $product,
        ]);
    }
}
