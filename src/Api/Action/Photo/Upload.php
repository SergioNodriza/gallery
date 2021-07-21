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
        try {

            $description = $request->request->get('description');
            $private = $request->request->get('private');
            $userIri = $request->request->get('owner');

            $file = $request->files->get('archive');
            [$fileName, ] = explode('.', $_FILES['archive']['name']);
        } catch (Exception $exception) {
            throw new BadRequestHttpException('Wrong Body Format');
        }

        return $this->photoUploadService->upload($file, $fileName, $description, $private, $userIri);
    }
}