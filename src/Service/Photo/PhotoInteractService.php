<?php


namespace App\Service\Photo;

use App\Exceptions\Photo\PhotoException;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class PhotoInteractService
{
    private const Like = "like";
    private const Liked = "Liked";
    private const AlreadyLiked = "Already Liked";

    private const Dislike = "dislike";
    private const Disliked = "Disliked";
    private const AlreadyDisliked = "Already Disliked";

    private EntityManagerInterface $entityManager;
    private PhotoRepository $photoRepository;

    public function __construct(EntityManagerInterface $entityManager, PhotoRepository $photoRepository)
    {
        $this->entityManager = $entityManager;
        $this->photoRepository = $photoRepository;
    }

    public function like($value, $photoId, $userIri): string
    {
        $photo = $this->photoRepository->findOneBy(['id' => $photoId]);
        $userId = substr($userIri, 11);
        $liked = in_array($userId, $photo->getUsersLiked(), true);

        switch ($value) {
            case self::Like:

                if ($liked === false) {
                    $photo->addUsersLiked($userId);
                    $result = self::Liked;
                } else {
                    $result = self::AlreadyLiked;
                }
                break;
            case self::Dislike:

                if ($liked === true) {
                    $photo->removeUsersLiked($userId);
                    $result = self::Disliked;
                } else {
                    $result = self::AlreadyDisliked;
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

        return $result;
    }
}