<?php


namespace App\Security\Authorization\Voter;

use App\Entity\User;
use App\Service\Roles\RolesService;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserVoter
{
    public const USER_READ = 'USER_READ';
    public const USER_REGISTER = 'USER_REGISTER';
    public const USER_UPDATE = 'USER_UPDATE';

    private RolesService $rolesService;

    public function __construct(RolesService $rolesService) {

        $this->rolesService = $rolesService;
    }

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
        $roles = $token->getRoleNames();
        $permissions = $this->rolesService->checkPermissions($roles);

//        if(in_array($attribute, [self::USER_READ, self::USER_UPDATE, self::USER_DELETE, self::USER_ADD_USER], true)) {
//            return $subject->isOwnedBy($token->getUser());
//        }

        try {
            return in_array($attribute, $permissions['photo'], true);
        }  catch (Exception $exception) {
            return false;
        }
    }

    private function supportedAttributes(): array
    {
        return [
            self::USER_READ,
            self::USER_REGISTER,
            self::USER_UPDATE,
        ];
    }
}