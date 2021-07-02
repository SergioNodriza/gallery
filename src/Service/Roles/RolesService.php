<?php


namespace App\Service\Roles;


class RolesService
{
    private const BASIC = "ROLE_BASIC";
    private const PREMIUM = "ROLE_PREMIUM";
    private const USER_PERMISSIONS = ["USER_READ", "USER_REGISTER", "USER_UPDATE"];
    private const PHOTO_PERMISSIONS = ["PHOTO_READ", "PHOTO_UPLOAD", "PHOTO_UPDATE", "PHOTO_DELETE", "PHOTO_INTERACT"];
    private const GROUP_PERMISSIONS = ["GROUP_READ", "GROUP_CREATE", "GROUP_UPDATE", "GROUP_DELETE", "GROUP_ADD_PHOTO"];


    public function checkPermissions(Array $roles): array
    {
        $permissions = [];

        foreach ($roles as $rol) {

            switch($rol) {
                case self::BASIC:
                    $permissions = [
                        'user' => self::USER_PERMISSIONS,
                        'photo' => self::PHOTO_PERMISSIONS
                    ];
                    break;
                case self::PREMIUM:
                    $permissions = [
                        'user' => self::USER_PERMISSIONS,
                        'photo' => self::PHOTO_PERMISSIONS,
                        'group' => self::GROUP_PERMISSIONS
                    ];
                    break;
                default:
                    break;
            }
        }
        return $permissions;
    }
}