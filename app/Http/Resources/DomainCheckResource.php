<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DomainCheckResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'domain'     => $this['domain'],
            'valid'      => (bool)$this['valid'],
            'status'     => $this['status'], // available 
            'expires_at' => $this['expires_at'],
            'message'    => $this['message'],
        ];
    }
}
