<?php


namespace App\Api\Action\Photo;

use App\Service\Photo\PhotoInteractService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Interact
{
    private PhotoInteractService $photoLikeService;

    public function __construct(PhotoInteractService $photoLikeService)
    {
        $this->photoLikeService = $photoLikeService;
    }

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $userIri = $request->toArray()['user'];
        } catch (Exception $exception) {
            throw new BadRequestHttpException('Wrong Body Format');
        }

        $result = $this->photoLikeService->like($id, $userIri);
        return new JsonResponse($result, 200);
    }
}