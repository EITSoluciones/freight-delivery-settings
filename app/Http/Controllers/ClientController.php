<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::paginate(10);
        return view('clients.index', compact('clients'));
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
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return redirect()->route('clients.index')
                ->withErrors($validator)
                ->withInput();
        }

        Client::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'expiration_date' => $request->input('expiration_date'),
            'activation_code' => Str::random(32),
            'url' => $request->input('url'),
        ]);

        return redirect()->route('clients.index')->with('success', 'Client created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => ['required', 'email', Rule::unique('clients')->ignore($client->id)],
            'address' => 'required|string|max:255',
            'expiration_date' => 'required|date',
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return redirect()->route('clients.index')
                ->withErrors($validator)
                ->withInput();
        }

        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Client updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully!');
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
