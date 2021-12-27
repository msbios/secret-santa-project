<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        $user = $this->userRepository->findOneBy([], ['id' => 'ASC']);
        return $this->render('dashboard/index.html.twig', [
            'total' => $this->userRepository->count([]),
            'user' => $user
        ]);
    }
}
