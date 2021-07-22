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

    public function create($name, $token): Group
    {
        $tokenParts = explode(".", $token);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtPayload = json_decode($tokenPayload);
        $userId = $jwtPayload->id;

        $user = $this->userRepository->findOneBy(['id' => $userId]);
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