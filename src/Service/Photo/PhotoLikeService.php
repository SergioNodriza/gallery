<?php


namespace App\Service\Photo;

use App\Entity\Photo;
use App\Exceptions\Photo\PhotoException;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class PhotoLikeService
{
    private EntityManagerInterface $entityManager;
    private PhotoRepository $photoRepository;

    public function __construct(EntityManagerInterface $entityManager, PhotoRepository $photoRepository)
    {
        $this->entityManager = $entityManager;
        $this->photoRepository = $photoRepository;
    }

    public function like($value, $photoId, $userIri): Photo
    {
        $photo = $this->photoRepository->findOneBy(['id' => $photoId]);
        $userId = substr($userIri, 11);

        $usersLiked = $photo->getUsersLiked();
        $liked = in_array($userId, $usersLiked, true);

        switch ($value) {
            case "like":
                if ($liked === false) {
                    $photo->addLike();
                    $photo->addUsersLiked($userId);
                }
                break;
            case "dislike":
                if ($liked === true) {
                    $photo->removeLike();
                    $photo->removeUsersLiked($userId);
                }
                break;
            default:
                throw PhotoException::fromRequestBodyFormat();
        }

        try {
            $this->entityManager->persist($photo);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            throw PhotoException::fromLike();
        }

        return $photo;
    }
}