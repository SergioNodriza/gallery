<?php


namespace App\Exceptions\Group;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class GroupException extends BadRequestException
{
    public static function fromSave(): self
    {
        throw new self('Error when trying to save the group');
    }

    public static function fromAddPhoto(): self
    {
        throw new self('Error on adding a Photo to the Group');
    }

    public static function fromRequestBodyFormat(): self
    {
        throw new self('Wrong Request Body Value');
    }
}