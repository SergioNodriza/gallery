<?php


namespace App\Security\Authorization\Voter;

use App\Entity\Photo;
use App\Service\Roles\RolesService;
use Exception;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PhotoVoter extends Voter
{
    public const PHOTO_READ = 'PHOTO_READ';
    public const PHOTO_UPLOAD = 'PHOTO_UPLOAD';
    public const PHOTO_UPDATE = 'PHOTO_UPDATE';
    public const PHOTO_DELETE = 'PHOTO_DELETE';
    public const PHOTO_INTERACT = 'PHOTO_INTERACT';

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
     * @param Photo|null $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $roles = $token->getRoleNames();
        $permissions = $this->rolesService->checkPermissions($roles);

        try {
            if(in_array($attribute, $permissions['photo'], true)) {

                if (in_array($attribute, [self::PHOTO_UPDATE, self::PHOTO_DELETE], true)) {
                    return $subject->isOwnedBy($token->getUser());
                }

                return true;
            }

            return false;
        }  catch (Exception $exception) {
            return false;
        }
    }

    private function supportedAttributes(): array
    {
        return [
            self::PHOTO_READ,
            self::PHOTO_UPLOAD,
            self::PHOTO_UPDATE,
            self::PHOTO_DELETE,
            self::PHOTO_INTERACT
        ];
    }
}