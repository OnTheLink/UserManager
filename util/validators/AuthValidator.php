<?php

namespace UserManager\Util\Validators;

class AuthValidator
{
    public function validateKeysExist(array $keysToValidate): bool
    {
        foreach ($keysToValidate as $key) {
            if (!isset($key)) {
                return false;
            }
        }

        return true;
    }

    public function validateLoginData(string $email, string $password): bool
    {
        return $this->validateKeysExist([$email, $password]);
    }

    public function validateRegisterData(string $firstName, string $lastName, string $email, string $password): bool
    {
        return $this->validateKeysExist([$firstName, $lastName, $email, $password]);
    }

    public function validateCookieData(string $email, string $cookie): bool
    {
        return $this->validateKeysExist([$email, $cookie]);
    }
}