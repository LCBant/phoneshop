<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Product;
use App\Repository\BrandRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(ProductRepository $productRepository, BrandRepository $brandRepository): Response
    {
        $featuredProducts = $productRepository->findBy(['is_featured' => 1], null, 4);
        $brands = $brandRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'featuredProducts' => $featuredProducts,
            'brands' => $brands
        ]);
    }

    #[Route('/aboutus', name: 'app_aboutus')]
    public function aboutus_page(): Response
    {
        return $this->render('home/about.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact_page(): Response
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

       #[Route('/register', name: 'app_register')]
    public function register_page(): Response
    {
        return $this->render('home/register.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

       #[Route('/login', name: 'app_login')]
    public function login_page(): Response
    {
        return $this->render('home/login.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
