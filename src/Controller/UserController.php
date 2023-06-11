<?php

/**
 * User controller.
 */

namespace App\Controller;

use App\Form\UserType;
use App\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController.
 *
 * @Route("/User")
 */
class UserController extends AbstractController
{
    private UserService $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService User service
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/admin/user/edit",
     *     methods={"GET", "PUT"},
     *     name="User_edit",
     * )
     */
    #[IsGranted("ROLE_ADMIN")]
    public function edit(Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user, ['method' => 'PUT', 'required' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPlainPassword = $form->get('newPassword')->getData();
            $this->userService->save($user, $newPlainPassword);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('User_edit');
        }

        return $this->render(
            'User/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
