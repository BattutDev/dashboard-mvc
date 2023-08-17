<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'security.login', methods: ['POST'])]
    public function login(): void
    {
        //Nothing
    }

    #[Route('/logout', name: 'security.logout')]
    public function logout(): void
    {
        //Nothing
    }
}
