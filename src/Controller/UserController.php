<?php

namespace App\Controller;

use App\Form\UserProfileEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/profile', name: 'app_user_view_profile')]
    public function profile(): Response
    {
        return $this->render('user/profile-view.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/profile/edit', name: 'app_user_edit_profile')]
    public function profileEdit(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserProfileEditType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_user_view_profile');
        }
        return $this->render('user/profile-edit.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form
        ]);
    }
}
