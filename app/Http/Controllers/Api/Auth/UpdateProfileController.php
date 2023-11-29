<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateProfileRequest $request)
    {
        // $image = $request->image;

        // $name = Str::uuid();

        // $userId  = auth()->user()->id;
        // $path = $userId.'/'.$name.'.'.$image->extension();
        
        // $request->image->storeAs('public/avatar', $path);
        $avatarUrl = auth()->user()->avatar_url;
        if ($avatarUrl != null && $avatarUrl != 'images/avatar_default.jpg') {
            Storage::delete('avatars/' . auth()->user()->avatar_url);
        }
        
        // Fazer upload do novo avatar
        
        $avatarName = time() . '.' . $request->avatar_url->extension();
        
        $request->avatar_url->storeAs('avatars', $avatarName);
    
        // Atualizar o campo avatar no modelo User
        auth()->user()->update(['avatar_url' => $avatarName]);

        return response()->json(['avatar_url' => auth()->user()->avatar_url], 200);
    }

    // private function deleteAvatar()
    // {
    //     $userId = auth()->user()->id;
    //     $path = 'public/avatar/'.$userId;

    //     if(Storage::)
    // }
}
