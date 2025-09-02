<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DomainWhoisService;
use App\Models\Domain;
use App\Http\Resources\DomainCheckResource;

class DomainCheckController extends Controller
{
    public function __construct(private DomainWhoisService $whois) {}

    // Проверяем ОДИН домен на запрос
    public function check(Request $r)
    {
        $data = $r->validate([
            'domain' => ['required','string','max:255'],
        ]);

        $domain = strtolower(trim($data['domain']));

        // валидация формата
        if (! $this->whois->isValid($domain)) {
            return new DomainCheckResource([
                'domain' => $domain,
                'valid' => false,
                'status' => 'invalid',
                'expires_at' => null,
                'message' => 'Invalid domain format',
            ]);
        }

        // проверяем в БД
        $db = Domain::where('name', $domain)->first();

        if ($db) {
            return new DomainCheckResource([
                'domain' => $domain,
                'valid' => true,
                'status' => 'taken',
                'expires_at' => $db->expires_at?->toDateString(),
                'message' => 'Domain is taken (from DB)',
            ]);
        }

        // иначе available
        return new DomainCheckResource([
            'domain' => $domain,
            'valid' => true,
            'status' => 'available',
            'expires_at' => null,
            'message' => 'Domain is available for purchase',
        ]);
    }
}
