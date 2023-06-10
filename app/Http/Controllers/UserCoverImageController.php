<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;

class UserCoverImageController extends Controller
{

    public function store(Request $request)
    {
        $request->validate(['image' => 'required|mimes:png,jpg,jpeg,webp']);

        try {
            $user = User::findOrFail(auth()->user()->id);
            $user = (new FileService)->updateCover($user, $request);
            $user->save();

            return response()->json('USER COVER IMAGE UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
