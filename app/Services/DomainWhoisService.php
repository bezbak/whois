<?php

namespace App\Services;

class DomainWhoisService
{
    public function isValid(string $domain): bool
    {
        $d = strtolower(trim($domain));
        return (bool) preg_match('/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,}$/i', $d);
    }
}
