<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LinksCollection;
use App\Http\Resources\UserResource;
use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(new UserResource(auth()->user()), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function  searchByName($term)
    {
        try {
            $users = User::where("name", "like", $term . "%")->get();
            return UserResource::collection($users);
        } catch (\Throwable $th) {

            return response()->json(["error" => $th]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([

            'name' => ['required', 'max:25', "unique:users,name,{$user->id}"],
            'bio' => 'sometimes|max:80',
            'designation' => 'sometimes',
            'full_name' => 'sometimes'
        ]);
        try {
            $user->update($data);

            return response()->json('USER DETAILS UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateContact(Request $request, User $user)
    {
        $data = $request->validate([
            'phone' => 'sometimes',
            'address' => 'sometimes',
            'website' => 'sometimes',
            'phone_visibility' => 'sometimes',
            'country_code' => 'sometimes'
        ]);
        try {
            $user->update($data);
            return response()->json('USER DETAILS UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($name)
    {
        try {
            $user = User::where("name", $name)->first();
            if ($user->phone_visibility == 0) {
                $user->phone = "";
            }
            $links = Link::where('user_id', $user->id)->orderBy('order', 'asc')->get();
            return response()->json(['user' => new UserResource($user), 'links' => new LinksCollection($links)]);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function checkName($name)
    {
        $user = User::where("name", $name)->first();
        if ($user) {
            return response()->json("false");
        }
        return response()->json("true");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
