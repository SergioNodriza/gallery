<?php


namespace App\Service\Photo;

use App\Exceptions\Photo\PhotoException;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class PhotoInteractService
{
    private EntityManagerInterface $entityManager;
    private PhotoRepository $photoRepository;

    public function __construct(EntityManagerInterface $entityManager, PhotoRepository $photoRepository)
    {
        $this->entityManager = $entityManager;
        $this->photoRepository = $photoRepository;
    }

    public function like($photoId, $token): array
    {
        $photo = $this->photoRepository->findOneBy(['id' => $photoId]);

        $tokenParts = explode(".", $token);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtPayload = json_decode($tokenPayload);
        $userId = $jwtPayload->id;

        $liked = in_array($userId, $photo->getUsersLiked(), true);

        if ($liked) {
            $photo->removeUsersLiked($userId);
        } else {
            $photo->addUsersLiked($userId);
        }

        try {
            $this->entityManager->persist($photo);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            throw PhotoException::fromLike();
        }

        return ['newLikes' => $photo->getLikes()];
    }
}