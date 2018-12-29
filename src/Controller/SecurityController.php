<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('security/login.html.twig', [
            'controller_name' => 'SecurityController',
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(
        Request $request,
        ObjectManager $manager,
        UserPasswordEncoderInterface $userPasswordEncoder,
        AuthenticationUtils $authenticationUtils)
    {
        $user = new User();

        $registerform = $this->createForm(RegisterType::class, $user);
        $registerform->handleRequest($request);

        if ($registerform->isSubmitted() && $registerform->isValid()) {

            $hash = $userPasswordEncoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Registration successful');
            return $this->redirectToRoute('login');
        }

        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('security/register.html.twig', [
            'form' => $registerform->createView(),
            'error' => $error
        ]);
    }
}
