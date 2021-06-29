<?php

namespace App\Service\User;

use App\Entity\User;
use App\Exceptions\User\AlreadyExistsException;
use App\Repository\UserRepository;
use App\Service\Password\EncoderService;
use App\Service\Request\RequestService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class UserRegisterService
{
    private EncoderService $encoderService;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, EncoderService $encoderService)
    {
        $this->encoderService = $encoderService;
        $this->entityManager = $entityManager;
    }

    public function create(Request $request): User
    {
        $name = $request->toArray()['name'];
        $email = $request->toArray()['email'];
        $password = $request->toArray()['password'];
        $roles = $request->toArray()['roles'];

        $user = new User($name, $email);
        $user->setPassword($this->encoderService->generateEncodedPassword($user, $password));
        $user->setRoles($roles);

        try {

            $this->entityManager->persist($user);
            $this->entityManager->flush();

        } catch (Exception $exception) {
            throw AlreadyExistsException::fromEmail($email);
        }

        return $user;
    }
}