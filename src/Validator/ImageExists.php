<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class ImageExists extends Constraint
{
    public const IMAGE_NOT_FOUND = 'Image not found';
    public string $message = self::IMAGE_NOT_FOUND;
}
