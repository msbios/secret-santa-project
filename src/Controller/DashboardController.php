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
    /** @var UserRepository */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $id
     * @return Response
     * @Route("/dashboard/{id}", name="dashboard")
     */
    public function index(string $id): Response
    {
        if (!$user = $this->userRepository->findOneBy(['id' => $id])) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('dashboard/index.html.twig', [
            'total' => $this->userRepository->count([]),
            'user' => $user
        ]);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route("/dashboard/rand", name="dashboard_rand")
     */
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
