<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
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
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($request->isMethod(Request::METHOD_POST) && $phone = $request->request->get('phone', null)) {
            if (!$user = $this->userRepository->findOneBy(['username' => $phone])) {
                $this->addFlash('danger', 'Нет участника с таким номером');
                return $this->redirectToRoute('app_login');
            }

            if (!$userPasswordHasher->isPasswordValid($user, $request->request->get('password'))) {
                $this->addFlash('danger', 'Неверный пароль');
                return $this->redirectToRoute('app_login');
            }

            return $this->redirectToRoute('dashboard', ['id' => $user->getId()]);
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @return RedirectResponse
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        return $this->redirectToRoute('app_login');
    }
}
