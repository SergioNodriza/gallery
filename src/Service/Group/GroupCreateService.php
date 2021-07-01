<?php


namespace App\Service\Group;

use App\Entity\Group;
use App\Exceptions\Group\GroupException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class GroupCreateService
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    public function create($name, $owner): Group
    {
        $user = $this->userRepository->findOneBy(['id' => substr($owner, 11)]);
        $group = new Group($name, $user);

        try {
            $this->entityManager->persist($group);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            throw GroupException::fromSave();
        }

        return $group;
    }
}