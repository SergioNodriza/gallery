<?php


namespace App\Service\Group;

use App\Entity\Group;
use App\Exceptions\Group\GroupException;
use App\Repository\GroupRepository;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class GroupPhotoService
{
    private EntityManagerInterface $entityManager;
    private GroupRepository $groupRepository;
    private PhotoRepository $photoRepository;

    public function __construct(EntityManagerInterface $entityManager, GroupRepository $groupRepository, PhotoRepository $photoRepository)
    {
        $this->entityManager = $entityManager;
        $this->groupRepository = $groupRepository;
        $this->photoRepository = $photoRepository;
    }

    public function addPhoto($id, $value, $photoIri): Group
    {
        $group = $this->groupRepository->findOneBy(['id' => $id]);
        $photo = $this->photoRepository->findOneBy(['id' => substr($photoIri, 11)]);

        switch ($value) {
            case "add":
                $group->addPhoto($photo);
                break;
            case "remove":
                $group->removePhoto($photo);
                break;
            default:
                throw GroupException::fromRequestBodyFormat();
        }

        try {
            $this->entityManager->persist($group);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            throw GroupException::fromAddPhoto();
        }

        return $group;
    }
}