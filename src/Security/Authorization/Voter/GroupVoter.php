<?php


namespace App\Security\Authorization\Voter;

use App\Entity\Group;
use App\Service\Roles\RolesService;
use Exception;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class GroupVoter extends Voter
{
    public const GROUP_READ = 'GROUP_READ';
    public const GROUP_CREATE = 'GROUP_CREATE';
    public const GROUP_UPDATE = 'GROUP_UPDATE';
    public const GROUP_DELETE = 'GROUP_DELETE';
    public const GROUP_ADD_PHOTO = 'GROUP_ADD_PHOTO';

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
     * @param Group|null $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $roles = $token->getRoleNames();
        $permissions = $this->rolesService->checkPermissions($roles);

        try {
            if (in_array($attribute, $permissions['group'], true)) {
                return $subject->isOwnedBy($token->getUser());
            }
            return false;
        }  catch (Exception $exception) {
            return false;
        }
    }

    private function supportedAttributes(): array
    {
        return [
            self::GROUP_READ,
            self::GROUP_CREATE,
            self::GROUP_UPDATE,
            self::GROUP_DELETE,
            self::GROUP_ADD_PHOTO
        ];
    }
}
