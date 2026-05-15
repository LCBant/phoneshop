<?php

namespace App\Controller;

use App\Entity\Brand;
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
    #[Route('/item/{slug}', name: 'app_product_detail')]
    public function productdetail(#[MapEntity(mapping: ['slug' => 'slug'])] Product $product): Response
    {
        return $this->render('product/productdetail.html.twig', [
            'controller_name' => 'ProductController',
            'product' => $product
        ]);
    }

    #[Route('/brands/{slug}', name: 'app_brand_detail')]
    public function brandDetail(#[MapEntity(mapping: ['slug' => 'slug'])] Brand $brand, ProductRepository $productRepository): Response
    {
        $products = $productRepository->findBy(['brand' => $brand]);

        return $this->render('product/branddetail.html.twig', [
            'brand' => $brand,
            'products' => $products
        ]);
    }
}
