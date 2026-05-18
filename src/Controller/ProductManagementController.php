<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/products')]
final class ProductManagementController extends AbstractController
{
    #[Route(name: 'app_product_management_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product_management/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('admin/products/new', name: 'app_product_management_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $product->setImage("no-photo.jpg");
        $product->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // create and set slug in a product
            $slug = strtolower(str_replace(' ', '-', $product->getName()));
            $product->setSlug($slug);
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_management_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_management/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('admin/product/{id}', name: 'app_product_management_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product_management/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('admin/product/{id}/edit', name: 'app_product_management_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_product_management_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_management/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('admin/product/delete/{id}', name: 'app_product_management_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_management_index', [], Response::HTTP_SEE_OTHER);
    }
}
