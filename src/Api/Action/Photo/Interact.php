<?php


namespace App\Api\Action\Photo;


use App\Entity\Photo;
use App\Service\Photo\PhotoInteractService;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Interact
{
    private PhotoInteractService $photoLikeService;

    public function __construct(PhotoInteractService $photoLikeService)
    {
        $this->photoLikeService = $photoLikeService;
    }

    public function __invoke(Request $request, string $id): Photo
    {
        try {
            $value = $request->toArray()['value'];
            $userIri = $request->toArray()['user'];
        } catch (Exception $exception) {
            throw new BadRequestHttpException('Wrong Body Format');
        }

        return $this->photoLikeService->like($value, $id, $userIri);
    }
}