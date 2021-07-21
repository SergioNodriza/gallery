<?php


namespace App\Service\Photo;


use App\Entity\Photo;
use App\Exceptions\Photo\PhotoException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class PhotoUploadService extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    public function upload(UploadedFile $file, string $fileName, string $description, bool $private, string $userIri): Photo
    {
        $newFileName = $fileName . '_' . sha1(uniqid('', false)) . '.' . $file->guessExtension();
        $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
        $file->move($destination, $newFileName);

        $user = $this->userRepository->findOneBy(['id' => substr($userIri, 11)]);
        $photo = new Photo($newFileName, $description, $private, $user);

        try {

            $this->entityManager->persist($photo);
            $this->entityManager->flush();

        } catch (Exception $exception) {
            throw PhotoException::fromSave();
        }

        return $photo;
    }
}