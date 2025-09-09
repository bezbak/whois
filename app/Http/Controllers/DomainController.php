<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;
use App\Http\Resources\DomainCheckResource;

class DomainController extends Controller
{
    public function index()
    {
        return DomainCheckResource::collection(
        Domain::orderBy('id','desc')->get()->map(function ($d) {
            return [
                'domain'     => $d->name,
                'valid'      => true,
                'status'     => 'taken',
                'expires_at' => $d->expires_at?->toDateString(),
                'message'    => 'From DB',
            ];
        })
    );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:domains,name',
            'expires_at' => 'nullable|date',
        ]);

        $domain = Domain::create([
            'name' => strtolower(trim($request->name)),
            'expires_at' => now()->addYear(),
            'user_id' => $request->user()?->id,
        ]);

        return response()->json([
            'message' => 'Domain added',
            'domain' => $domain,
        ], 201);
    }
}
