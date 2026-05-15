<?php

namespace App\Controller;

use App\Entity\Product;
use App\Enum\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
# use slug instead of id
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

final class ProductController extends AbstractController
{
    #[Route('/phones', name: 'app_phones')]
    public function phonelist(ProductRepository $productRepository): Response
    {
        $phones = $productRepository->findBy(["type" => ProductType::Phone]);

        return $this->render('product/phonelist.html.twig', [
            'controller_name' => 'ProductController',
            'phones' => $phones
        ]);
    }

    #[Route('/accessories', name: 'app_accessories')]
    public function accessorylist(ProductRepository $productRepository): Response
    {
        $accessories = $productRepository->findBy(["type" => ProductType::Accessory]);

        return $this->render('product/accessorylist.html.twig', [
            'controller_name' => 'ProductController',
            'accessories' => $accessories
        ]);
    }

    # details route with slug instead of id
    #[Route('/product/{slug}', name: 'app_product_detail')]
    public function phonedetail(#[MapEntity(mapping: ['slug' => 'slug'])] Product $product): Response
    {
        return $this->render('product/productdetail.html.twig', [
            'controller_name' => 'ProductController',
            'product' => $product
        ]);
    }

}
