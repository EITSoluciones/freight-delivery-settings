<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Show the form for creating a new client.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:clients,email',
            'address' => 'required|string|max:255',
            'expiration_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->route('clients.create')
                ->withErrors($validator)
                ->withInput();
        }

        $client = Client::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'expiration_date' => $request->input('expiration_date'),
            'activation_code' => Str::random(32),
        ]);

        return redirect()->route('clients.create')->with('success', 'Client created successfully! Activation code: ' . $client->activation_code);
    }

    /**
     * Get client by activation code.
     *
     * @param  string  $activation_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByActivationCode($activation_code)
    {
        $client = Client::where('activation_code', $activation_code)->first();

        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        if (now()->gt($client->expiration_date)) {
            return response()->json(['error' => 'Activation code expired'], 403);
        }

        return response()->json($client);
    }
}
