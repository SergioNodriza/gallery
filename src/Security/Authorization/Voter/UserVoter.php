<?php


namespace App\Security\Authorization\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    public const USER_UPDATE = 'USER_UPDATE';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, $this->supportedAttributes(), true);
    }

    /**
     * @param string $attribute
     * @param User|null $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if($attribute === self::USER_UPDATE) {
            return $subject->equals($token->getUser());
        }

        return false;
    }

    private function supportedAttributes(): array
    {
        return [
            self::USER_UPDATE
        ];
    }
}