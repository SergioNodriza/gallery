<?php


namespace App\Service\Photo;

use App\Entity\Photo;
use App\Exceptions\Photo\PhotoException;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class PhotoLikeService
{
    private EntityManagerInterface $entityManager;
    private PhotoRepository $photoRepository;

    public function __construct(EntityManagerInterface $entityManager, PhotoRepository $photoRepository)
    {
        $this->entityManager = $entityManager;
        $this->photoRepository = $photoRepository;
    }

    public function like($value, string $id): Photo
    {
        $photo = $this->photoRepository->findOneBy(['id' => $id]);

        switch ($value) {
            case "like":
                $photo->addLike();
                break;
            case "dislike":
                $photo->removeLike();
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