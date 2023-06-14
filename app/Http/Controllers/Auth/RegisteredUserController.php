<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Google\Client;


class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);

            return response()->noContent();
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
    public function googleRegister(Request $request)
    {
        $data = $request->validate([
            "credential" => 'required',
            "client_id" => 'required'
        ]);
        $client = new Client(['client_id' => $data['client_id']]);
        $payload = $client->verifyIdToken($data['credential']);

        if (!$payload) {
            return response()->json(["error" => "wrong credentials"], 401);
        }

        $email = $payload['email'];

        $user = User::where('email', $email)->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            return response()->json("successfully logged in");
        }


        $name  = str_replace(" ", '_', $payload['name']);

        $image  = $payload['picture'];
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->image = $image;
        $user->password = Hash::make("hello world");

        try {
            //code...
            $user->save();

            Auth::login($user);
            return response()->json("successfully registered");
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }
}
