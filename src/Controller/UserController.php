<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserController extends AbstractController
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;


    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/dashboard/users', name: 'index.users', methods: ['GET'])]
    public function index(#[CurrentUser] User $user): Response
    {

        $users = $this->userRepository->findAll();
        return $this->render('dashboard/users/index.html.twig',
            [
                "breadcrumbs" => [
                    "paths" => [['Dashboard', '/dashboard/']],
                    "page" => 'Users'
                ],
                "user" => $user,
                "users" => $users

        ]);
    }

    #[Route('/dashboard/users/{id<\d+>?}', name: 'id.users', methods: ['GET'])]
    public function id(int $id, #[CurrentUser] User $user): Response {

        $selectedUser = $this->userRepository->findOneBy(['id' => $id]);
        if (!$selectedUser) return $this->redirect('/dashboard/users/');
        else return $this->render('dashboard/users/user.html.twig',
            [
                "breadcrumbs" => [
                    "paths" => [['Dashboard', '/dashboard/'], ['Utilisateurs', '/dashboard/users']],
                    "page" => 'Informations'
                ],
                "user" => $user,
                "selected_user" => $selectedUser
            ]);
    }

    #[Route('/dashboard/users/new', name: 'new.users', methods: ['GET'])]
    public function new(#[CurrentUser] User $user, #[MapQueryParameter] ?string $e = null): Response {


        return $this->render('dashboard/users/new.html.twig',
            [
                "breadcrumbs" => [
                    "paths" => [['Dashboard', '/dashboard/'], ['Utilisateurs', '/dashboard/users']],
                    "page" => 'Nouveau'
                ],
                "user" => $user,
                "error" => $e
            ]);
    }

    #[Route('/dashboard/users/insert', name: 'insert.users', methods: ['POST'])]
    public function insert(Request $request): Response {

        $first_name = $request->get('firstname');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        $password = $request->get('password');
        $confirm = $request->get('confirm-password');

        $error = null;
        if (!$first_name || !$lastname || !$email || !$password || !$confirm) return $this->redirect('/dashboard/users/new?e=fields');
        if ($password !== $confirm) return $this->redirect('/dashboard/users/new?e=passwords');

        $user = new User();
        $user->setEmail($email)
            ->setFirstName($first_name)
            ->setLastName($lastname)
            ->setPlainPassword($password);
        $this->entityManager->persist($user);
        $this->entityManager->flush();


        return $this->redirect('/dashboard/users/' . $user->getId());
    }

    #[Route('/dashboard/users/delete/{id<\d+>?}', name: 'delete.users', methods: ['GET'])]
    public function delete(#[CurrentUser] User $user, int $id): Response {

        if (!in_array('ROLE_ADMIN', $user->getRoles())) return $this->redirect('/dashboard/users', 401);

        if ($user->getId() === $id) return $this->redirect('/dashboard/users', 401);

        $selectedUser = $this->userRepository->findOneBy(['id' => $id]);

        if ($selectedUser) {
            $this->entityManager->remove($selectedUser);
            $this->entityManager->flush();

        }

        return $this->redirect('/dashboard/users');
    }

    #[Route('/dashboard/users/{id<\d+>?}/roles', name: 'roles.users', methods: ['GET'])]
    public function roles(int $id, #[MapQueryParameter('name')] ?string $name = null, #[MapQueryParameter('action')] ?string $action = null): Response
    {

        if (!$name || !$action) return $this->redirect('/dashboard/users/' . $id);

        $user = $this->userRepository->findOneBy(['id' => $id]);

        if ($user) {
            $roles = $user->getRoles();
            if ($action === 'remove') {
                if (($key = array_search($name, $roles)) !== false) {
                    unset($roles[$key]);
                }
            } else if ($action === 'add') {
                if (in_array($name, ['ROLE_USER', 'ROLE_MANAGER'])) {
                    $roles[] = $name;
                }
            }

            $user->setRoles($roles);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return $this->redirect('/dashboard/users/' . $id);


    }

}
