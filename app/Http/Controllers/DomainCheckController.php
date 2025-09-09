<?php

namespace App\Http\Controllers;

use App\Http\Requests\DomainCheckRequest;
use App\Http\Resources\DomainCheckResource;
use App\Services\DomainWhoisService;

class DomainCheckController extends Controller
{
    public function __construct(private DomainWhoisService $whois) {}

    public function check(DomainCheckRequest $request)
    {
        $data = $this->whois->checkDomain($request->validated()['domain']);

        return new DomainCheckResource($data);
    }
}
