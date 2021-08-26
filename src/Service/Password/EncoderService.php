<?php


namespace App\Service\Password;


use App\Entity\User;
use App\Exceptions\Password\PasswordException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EncoderService
{
    private const MINIMUM_LENGTH = 6;
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function generateEncodedPassword(UserInterface $user, string $password) {

        if (self::MINIMUM_LENGTH > strlen($password)) {
            throw PasswordException::invalidLength();
        }

        return $this->userPasswordEncoder->encodePassword($user, $password);
    }
}