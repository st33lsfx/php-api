<?php

namespace App\Controller\Api;

use App\Entity\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/api/user/{id}', name: 'app_user_detail', methods: ['GET'])]
    public function detailUser(User $user): JsonResponse
    {
       $seriallized = $this->serializer->serialize($user, 'json');

       return new JsonResponse($seriallized, 200, [], true);
    }
}
