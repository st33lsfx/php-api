<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseService
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function createTrueResponse(): JsonResponse
    {
        return new JsonResponse(['ok' => true]);
    }

    public function createFalseResponse(string $message, int $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR, array $errors = null): JsonResponse
    {
        $response = [
            "ok" => false,
            "message" => $message
        ];

        if($errors) {
            $response["errors"] = $errors;
        }

        return new JsonResponse($response, $httpCode);
    }

    public function createResponse($data): JsonResponse
    {
        $serializedData = $this->serializer->serialize($data, 'json');
        return new JsonResponse($serializedData,Response::HTTP_OK, [], true);
    }
}
