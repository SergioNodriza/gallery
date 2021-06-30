<?php

namespace App\Service\User;

use App\Entity\User;
use App\Exceptions\User\AlreadyExistsException;
use App\Service\Password\EncoderService;
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

    public function create($name, $email, $password): User
    {
        $user = new User($name, $email);
        $user->setPassword($this->encoderService->generateEncodedPassword($user, $password));

        try {

            $this->entityManager->persist($user);
            $this->entityManager->flush();

        } catch (Exception $exception) {
            throw AlreadyExistsException::fromEmail($email);
        }

        return $user;
    }
}