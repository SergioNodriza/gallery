<?php


namespace App\Service\Group;

use App\Exceptions\Group\GroupException;
use App\Repository\GroupRepository;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class GroupPhotoService
{
    private const Add = "add";
    private const Added = "Added";
    private const AlreadyAdded = "Already Added";

    private const Remove = "remove";
    private const Removed = "Removed";
    private const NotInGroup = "Not in Group";

    private EntityManagerInterface $entityManager;
    private GroupRepository $groupRepository;
    private PhotoRepository $photoRepository;

    public function __construct(EntityManagerInterface $entityManager, GroupRepository $groupRepository, PhotoRepository $photoRepository)
    {
        $this->entityManager = $entityManager;
        $this->groupRepository = $groupRepository;
        $this->photoRepository = $photoRepository;
    }

    public function addPhoto($id, $photoIri): array
    {
        $group = $this->groupRepository->findOneBy(['id' => $id]);
        $photo = $this->photoRepository->findOneBy(['id' => substr($photoIri, 12)]);
        $added = in_array($photo, $group->getPhotos()->toArray(), true);

        if ($added) {
            $group->removePhoto($photo);
            $result = self::Removed;
        } else {
            $group->addPhoto($photo);
            $result = self::Added;
        }

        try {
            $this->entityManager->persist($group);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            throw GroupException::fromAddPhoto();
        }

        return ['result' => $result];
    }
}