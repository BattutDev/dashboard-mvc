<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig',

            [
                "breadcrumbs" => [
                    "paths" => [['Dashboard', '/dashboard/']],
                    "page" => 'Acceuil'
                ]
            ]
        );
    }
}
