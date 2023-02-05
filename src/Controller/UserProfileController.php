<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/user/profile")
 */
class UserProfileController extends AbstractController
{
    /**
     * @Route("/", name="app_user_profile_show", methods={"GET"})
     */
    public function show(): Response
    {
        $user = $this->getUser();
        return $this->render('user_profile/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit", name="app_user_profile_edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );

            $userRepository->upgradePassword($user, $hashedPassword);

            $userRepository->add($user, true);

            return $this->redirectToRoute(
                'app_user_profile_show',
                [],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('user_profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/", name="app_user_profile_delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        UserRepository $userRepository
    ): Response {
        $user = $this->getUser();
        if (
            $this->isCsrfTokenValid(
                'delete' . $user->getUserIdentifier(),
                $request->request->get('_token')
            )
        ) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute(
            'app_user_profile_index',
            [],
            Response::HTTP_SEE_OTHER
        );
    }
}
