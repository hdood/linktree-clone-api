<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Google\Client;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    public function googleLogin(Request $request)
    {
        $data = $request->validate([
            "credential" => 'required',
            "client_id" => 'required'
        ]);
        $client = new Client(['client_id' => $data['client_id']]);
        $payload = $client->verifyIdToken($data['credential']);
        if ($payload) {
            $email = $payload['email'];
            $user = User::where("email", $email)->first();
            if (!$user) {

                return;
            }
            Auth::guard('web')->login($user);
            $request->session()->regenerate();
            return response()->json(["successfully logged in"], 200);
        }
        return response()->json(["error" => "something went wrong"], 401);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
