<?php


namespace App\Api\Action\Photo;


use App\Entity\Photo;
use App\Service\Photo\PhotoLikeService;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Like
{
    private PhotoLikeService $photoLikeService;

    public function __construct(PhotoLikeService $photoLikeService)
    {
        $this->photoLikeService = $photoLikeService;
    }

    public function __invoke(Request $request, string $id): Photo
    {
        try {
            $value = $request->toArray()['value'];
        } catch (Exception $exception) {
            throw new BadRequestHttpException('Wrong Body Format');
        }

        return $this->photoLikeService->like($value, $id);
    }
}