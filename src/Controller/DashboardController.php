<?php

namespace App\Controller;

use App\Entity\User;
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

    /**
     * @return User
     */
    private function current(): User
    {
        return $this->userRepository->findOneBy([], ['id' => 'ASC']);
    }

    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        $user = $this->current();
        return $this->render('dashboard/index.html.twig', [
            'total' => $this->userRepository->count([]),
            'user' => $user
        ]);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/rand', name: 'dashboard_rand')]
    public function rand(EntityManagerInterface $entityManager): Response
    {
        /** @var array $all */
        $all = $this->userRepository->findAll();

        foreach ($all as $user) {
            do {
                $isDone = false;
                $children = $this->userRepository->findChildFor($user);
                shuffle($children);
                $child = $children[count($children) - 1];
                if (!$this->userRepository->count(['child' => $child])) {
                    $user->setChild($child);
                    $entityManager->flush();
                    $isDone = false;
                } else {
                    $isDone = true;
                }
            } while ($isDone);
        }

        return $this->redirectToRoute('dashboard');
    }
}
