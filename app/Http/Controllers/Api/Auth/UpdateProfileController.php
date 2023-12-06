<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\Clients\ProfileResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UpdateProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // dd($request->file('avatar_url'));
        $avatarUrl = auth()->user()->avatar_url;
        if ($avatarUrl != null && $avatarUrl != 'images/avatar_default.jpg') {
            // dd(auth()->user()->avatar_url);
            Storage::delete('public/avatars/' . auth()->user()->avatar_url);
        }

        // dd($request->all());
        // dd($request->hasFile('avatar_url'));
        // if ($request->file('avatar_url')) {
        //     $fileName = time() . '.' . $request->avatar_url->extension();
        // }



        // $user = auth()->user();

        // $user->update(['avatar_url' => '/storage/avatars/' . $fileName]);
        // $user->update(['avatar_url' => $fileNam);

        // return new ProfileResource($user);
        $file = $request->input('avatar_url');
        // dd($file);
        $bytes = base64_decode($file);
        $image = Image::make($bytes);

        // // dd('ok', $image);
        // // dd($image);

        // Storage::put('imagens/' . $image->basename(), $image->get());

        // $request->avatar_url->storeAs('avatars', $image, 'public');
        // dd($image);
        return response()->json($image);
    }
}
