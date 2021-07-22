<?php


namespace App\Api\Action\Photo;

use App\Service\Photo\PhotoInteractService;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Interact
{
    private PhotoInteractService $photoLikeService;
    private TokenExtractorInterface $tokenExtractor;

    public function __construct(PhotoInteractService $photoLikeService, TokenExtractorInterface $tokenExtractor)
    {
        $this->photoLikeService = $photoLikeService;
        $this->tokenExtractor = $tokenExtractor;
    }

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $token = $this->tokenExtractor->extract($request);
        } catch (Exception $exception) {
            throw new BadRequestHttpException('Wrong Body Format');
        }

        $result = $this->photoLikeService->like($id, $token);
        return new JsonResponse($result, 200);
    }
}