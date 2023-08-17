<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard.index', methods: ['GET'])]
    public function index(#[CurrentUser] User $user): Response
    {
        return $this->render('dashboard/index.html.twig',
            [
                "breadcrumbs" => [
                    "paths" => [['Dashboard', '/dashboard/']],
                    "page" => 'Acceuil'
                ],
                "user" => $user
            ]
        );
    }
}
