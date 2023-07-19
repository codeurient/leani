<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nette\Utils\Random;

class PhoneCode extends Model
{
    const CODE_LENGTH = 6;
    const CODE_REPEAT_SECONDS = 20;

    public static function generateCode(): string
    {
        return Random::generate(self::CODE_LENGTH, '0-9');
    }
}
