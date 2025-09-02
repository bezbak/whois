<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;

class DomainController extends Controller
{
    public function index()
    {
        return response()->json(Domain::orderBy('id','desc')->get());
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
