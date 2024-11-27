<?php

namespace App\Utils;

class CustomEncryption
{
  private const SALT = 'chave_5seg_av2';

  public static function encrypt(string $password): string
  {
    $hashed = hash('sha256', self::SALT . $password);
    return $hashed;
  }

  public static function verify(string $password, string $hashedPassword): bool
  {
    return self::encrypt($password) === $hashedPassword;
  }
}
