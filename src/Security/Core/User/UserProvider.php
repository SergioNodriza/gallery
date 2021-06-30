<?php


namespace App\Security\Core\User;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @method UserInterface loadUserByIdentifier(string $identifier)
 */
class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager) {

        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of %s are not supported', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        try {
            return $this->userRepository->findOneBy(['email' => $username]);
        } catch (UserNotFoundException $exception) {
            throw new UserNotFoundException(sprintf('User %s not found', $username));
        }
    }

    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        $user->setPassword($newEncodedPassword);

        $this->entityManager->persist($user);
    }

    public function supportsClass(string $class)
    {
        return User::class === $class;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method UserInterface loadUserByIdentifier(string $identifier)
    }
}