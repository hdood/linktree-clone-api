<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{



    public function index(User $user)
    {
        return $user->medias;
    }

    public function storeEmbeddedMedia(Request $request)
    {
        $data = $request->validate([
            'type' => ['required'],
            'data' => ['required'],
            'user_id' => ['required']
        ]);
        try {
            Media::create($data);
            return response()->json('Media created successfully');
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()]);
        }
    }

    public function storeFileMedia(Request $request)
    {
        $data = $request->validate([
            'media' => 'required|mimes:png,jpg,webp,jpeg,pdf,mp4',
            'user_id' => 'required',
            'data' => 'required',
            "type" => "required",
            'title' => "required"
        ]);

        $path = Storage::disk("media")->put("", $request->file("media"));

        $media = new Media();

        $media->type = $data['type'];
        $media->user_id = $data['user_id'];
        $media->data = json_encode(["url" => url("/media/") . "/" .  $path, "title" => $data['title']]);

        $media->save();

        return $media->data;
    }
}
