<?php

namespace App\Services;

use App\Models\Domain;

class DomainWhoisService
{
    public function isValid(string $domain): bool
    {
        $d = strtolower(trim($domain));
        return (bool) preg_match(
            '/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,}$/i',
            $d
        );
    }

    public function checkDomain(string $domain): array
    {
        $domain = strtolower(trim($domain));

        if (! $this->isValid($domain)) {
            return [
                'domain'     => $domain,
                'valid'      => false,
                'status'     => 'invalid',
                'expires_at' => null,
                'message'    => 'Invalid domain format',
            ];
        }

        $db = Domain::where('name', $domain)->first();

        if ($db) {
            return [
                'domain'     => $domain,
                'valid'      => true,
                'status'     => 'taken',
                'expires_at' => $db->expires_at?->toDateString(),
                'message'    => 'Domain is taken (from DB)',
            ];
        }

        return [
            'domain'     => $domain,
            'valid'      => true,
            'status'     => 'available',
            'expires_at' => null,
            'message'    => 'Domain is available for purchase',
        ];
    }
}
