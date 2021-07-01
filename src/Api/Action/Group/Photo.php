<?php


namespace App\Api\Action\Group;

use App\Entity\Group;
use App\Service\Group\GroupPhotoService;
use App\Service\Group\GroupCreateService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Photo
{
    private GroupPhotoService $groupAddPhotoService;

    public function __construct(GroupPhotoService $groupAddPhotoService)
    {
        $this->groupAddPhotoService = $groupAddPhotoService;
    }

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $value = $request->toArray()['value'];
            $photoIri = $request->toArray()['photo'];
        } catch (Exception $exception) {
            throw new BadRequestHttpException('Wrong Body Format');
        }

        $result = $this->groupAddPhotoService->addPhoto($id, $value, $photoIri);
        return new JsonResponse($result, 200, [], true);
    }
}