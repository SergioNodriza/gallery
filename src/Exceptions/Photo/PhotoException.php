<?php


namespace App\Exceptions\Photo;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PhotoException extends BadRequestException
{
    public static function fromSave(): self
    {
        throw new self('Error when trying to save the photo');
    }

    public static function fromLike(): self
    {
        throw new self('Error on like to the photo');
    }

    public static function fromRequestBodyFormat(): self
    {
        throw new self('Wrong Request Body Value');
    }
}