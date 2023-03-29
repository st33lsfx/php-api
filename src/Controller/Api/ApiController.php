<?php

namespace App\Controller\Api;

use App\Entity\User\User;
use App\Service\ResponseService;
use App\Service\User\UserService;
use App\Form\User\CreateUserType;
use App\Model\User\UserModel;
use App\Repository\User\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    private SerializerInterface $serializer;
    private UserRepository $userRepository;
    private ResponseService $responseService;
    private UserService $userService;

    public function __construct(SerializerInterface $serializer, UserRepository $userRepository, ResponseService $responseService, UserService $userService)
    {
        $this->serializer = $serializer;
        $this->userRepository = $userRepository;
        $this->responseService = $responseService;
        $this->userService = $userService;
    }

    #[Route('/api/user/all', name: 'app_user_list', methods: ['GET'])]
    public function userList(): JsonResponse
    {
        $users = $this->userRepository->findAll();
        $userSerialized = $this->serializer->serialize($users, 'json');

        return new JsonResponse($userSerialized, 200, [], true);
    }

    #[Route('/api/user/{id}', name: 'app_user_detail', methods: ['GET'])]
    public function detailUser(User $user): JsonResponse
    {
        $seriallized = $this->serializer->serialize($user, 'json');

        return new JsonResponse($seriallized, 200, [], true);
    }

    #[Route('api/user/create', name: 'app_user_create', methods: ['PUT'])]
    #[IsGranted("ROLE_ADMIN")]
    public function create(Request $request): Response
    {
        $newUserModel = new UserModel();
        $form = $this->createForm(CreateUserType::class, $newUserModel);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            try {
                $this->userService->createUser($newUserModel);
            } catch (\Exception $exception) {
                return $this->responseService->createFalseResponse($exception->getMessage());
            }
        }
        return $this->responseService->createTrueResponse();
    }

    #[Route('api/{id}/delete', name: 'app_user_delete', methods: ['DELETE'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(User $user): Response
    {

        try {
            $this->userRepository->remove($user);
        } catch (\Exception $exception) {
            return $this->responseService->createFalseResponse($exception->getMessage());
        }

        return $this->responseService->createTrueResponse();
    }
}
