<?php


namespace App\Service\Photo;


use App\Entity\Photo;
use App\Exceptions\Photo\PhotoException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class PhotoUploadService
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    public function upload($archive, string $description, bool $private, string $userIri): Photo
    {
        $user = $this->userRepository->findOneBy(['id' => substr($userIri, 11)]);
        $photo = new Photo($archive, $description, $private, $user);

        try {

            $this->entityManager->persist($photo);
            $this->entityManager->flush();

        } catch (Exception $exception) {
            throw PhotoException::fromSave();
        }

        return $photo;
    }
}