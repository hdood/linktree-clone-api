<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserPortfolioController extends Controller
{



    public function store(Request $request)
    {
        $request->validate(['portfolio' => 'required|mimes:png,jpg,webp,jpeg,pdf', 'user_id' => 'required']);
        $user = User::find($request->user_id);


        if (!$user) {
            return response()->json("user does not exist", 401);
        }

        if (Storage::exists($user->portfolio)) {
            Storage::delete($user->portfolio);
        }


        $link = $request->file('portfolio')->store('public');

        $user->portfolio = $link;
        $user->save();

        return response()->noContent();
    }



    public function download(Request $request)
    {

        $request->validate(["user_id" => "required"]);
        $user = User::find($request->user_id);
        $portfolio = $user->portfolio;
        return Storage::download($portfolio);
    }
}
