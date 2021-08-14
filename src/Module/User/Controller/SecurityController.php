<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\User\Controller;

use Desksheet\Module\User\Model\UserInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Desksheet\Module\User\Enum\Route as RouteEnum;

class SecurityController extends AbstractController
{
    #[Route('/login', name: RouteEnum::LOGIN)]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute(RouteEnum::LOGIN_SUCCESS);
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/login/success', name: RouteEnum::LOGIN_SUCCESS)]
    public function success(): Response
    {
        // This action used to redirect user to success page.
        return $this->redirectToRoute('user_profile');
    }

    #[Route('/logout', name: RouteEnum::LOGOUT)]
    public function logout(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
