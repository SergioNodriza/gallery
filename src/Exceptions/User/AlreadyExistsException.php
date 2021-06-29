<?php


namespace App\Exceptions\User;


use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class AlreadyExistsException extends ConflictHttpException
{
    private const MESSAGE = 'User with email %s already exist';

    public static function fromEmail(string $email): self
    {
        throw new self(sprintf(self::MESSAGE, $email));
    }
}