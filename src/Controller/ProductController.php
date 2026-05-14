<?php

namespace App\Controller;

use App\Enum\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
