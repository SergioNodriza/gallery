<?php


namespace App\Api\Action\Photo;


use App\Entity\Photo;
use App\Service\Photo\PhotoUploadService;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Upload
{
    private PhotoUploadService $photoUploadService;

    public function __construct(PhotoUploadService $photoUploadService)
    {
        $this->photoUploadService = $photoUploadService;
    }

    public function __invoke(Request $request): Photo
    {
        $requestArray = $request->toArray();

        try {
            $archive = $requestArray['archive'];
            $description = $requestArray['description'];
            $private = $requestArray['private'];
            $userIri = $requestArray['user'];
        } catch (Exception $exception) {
            throw new BadRequestHttpException('Wrong Body Format');
        }

        return $this->photoUploadService->upload($archive, $description, $private, $userIri);
    }
}