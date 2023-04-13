<?php

namespace App\Controller\Api;

use App\Entity\Followers\Followers;
use App\Entity\User\User;
use App\Model\User\UserFilter;
use App\Repository\Followers\FollowersRepository;
use App\Service\ResponseService;
use App\Service\User\UserService;
use App\Model\User\UserModel;
use App\Repository\User\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ApiController extends AbstractController
{
    private UserRepository $userRepository;
    private ResponseService $responseService;
    private UserService $userService;
    private FollowersRepository $followersRepository;

    public function __construct(
        UserRepository $userRepository,
        ResponseService $responseService,
        UserService $userService,
        FollowersRepository $followersRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->responseService = $responseService;
        $this->userService = $userService;
        $this->followersRepository = $followersRepository;
    }

    #[Route('/api/user/all', name: 'app_user_list', methods: ['GET'])]
    public function userListAll(Request $request): JsonResponse
    {
        $userFilter = new UserFilter();
        $data = json_decode($request->getContent(), true);

        $userFilter->setPage($data["page"]);
        $userFilter->setLimit($data["limit"]);
        $userFilter->setSortByNick($data["sortByNick"]);
        $userFilter->setSortDirection($data["sortDirection"]);

        $users = $this->userRepository->getUsersByFilter($userFilter);

        $response = [];

        foreach ($users as $user) {
            $response[] = [
                'id' => $user->getId(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'nick' => $user->getNick(),
                'count_followers' => $user->getFollowers()->count(),
                'created_at' => $user->getCreateAt(),
            ];
        }

        if ($response) {
            return $this->responseService->createResponse($response);
        }

        return $this->responseService->createFalseResponse('Bad request');
    }

    #[Route('/api/user/{id}', name: 'app_user_detail', methods: ['GET'])]
    public function userDetail(string $id): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        if (!$user) {
            return $this->responseService->createFalseResponse('User not found', Response::HTTP_NOT_FOUND);
        }

        $response = [
            'id' => $user->getId(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'nick' => $user->getNick(),
            'count_followers' => $user->getFollowers()->count(),
            'created_at' => $user->getCreateAt(),
        ];

        if ($response) {
            return $this->responseService->createResponse($response);
        }

        return $this->responseService->createFalseResponse('Bad request');
    }

    #[Route('/api/user/{id}/follow', name: 'app_follow_user', methods: ['PATCH'])]
    public function followUser(string $id, UserRepository $userRepository): JsonResponse
    {
        $currentUser = $this->getUser();

        $userToFollow = $userRepository->find($id);

        if (!$userToFollow) {
            return $this->responseService->createFalseResponse('User not found', Response::HTTP_NOT_FOUND);
        }

        if ($currentUser !== $userToFollow) {

            $followers = new Followers();
            $followers->setFollow($userToFollow);
            $followers->setFollower($currentUser);
            $followers->setCreateAt(new \DateTimeImmutable());

            $this->followersRepository->save($followers, true);

            return $this->responseService->createTrueResponse();
        }

        return $this->responseService->createFalseResponse('You cannot follow yourself');
    }

    #[Route('/api/user/{id}/followers', name: 'app_user_followers_list', methods: ['GET'])]
    public function userListFollowers(string $id): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        if (!$user) {
            return $this->responseService->createFalseResponse('User not found', Response::HTTP_NOT_FOUND);
        }

        $followers = $user->getFollowers();

        $response = [
            'id' => $user->getId(),
            'followers' => [],
        ];

        foreach ($followers as $follower) {
            $response['followers'][] = [
                'id' => $follower->getId(),
                'follower_id' => $follower->getFollower()->getId(),
                'followed_id' => $follower->getFollow()->getId(),
                'created_at' => $follower->getCreateAt(),
            ];
        }

        return $this->responseService->createResponse($response);
    }


    #[Route('api/user/create', name: 'app_user_create', methods: ['PUT'])]
    #[IsGranted("ROLE_ADMIN")]
    public function createUser(Request $request): Response
    {
        $newUserModel = new UserModel();
        $data = json_decode($request->getContent(), true);
        $newUserModel->firstName = $data['firstName'];
        $newUserModel->lastName = $data['lastName'];
        $newUserModel->nick = $data['nick'];
        $newUserModel->password = $data['password'];

        try {
            $newUser = $this->userService->createUser($newUserModel);
            $this->userRepository->save($newUser, true);
            return $this->responseService->createTrueResponse();
        } catch (\Exception $exception) {
            return $this->responseService->createFalseResponse($exception->getMessage());
        }
    }

    #[Route('api/user/{id}/delete', name: 'app_user_delete', methods: ['DELETE'])]
    #[IsGranted("ROLE_ADMIN")]
    public function deleteUser(User $user): Response
    {

        try {
            $this->userRepository->remove($user, true);
        } catch (\Exception $exception) {
            return $this->responseService->createFalseResponse($exception->getMessage());
        }

        return $this->responseService->createTrueResponse();
    }
}
