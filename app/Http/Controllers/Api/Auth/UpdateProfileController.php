<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\Clients\ProfileResource;
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
        $avatarUrl = auth()->user()->avatar_url;
        if ($avatarUrl != null && $avatarUrl != 'images/avatar_default.jpg') {
            // dd(auth()->user()->avatar_url);
            Storage::delete('public/avatars/'.auth()->user()->avatar_url);
        }
        
        $fileName = time() . '.' . $request->avatar_url->extension();
        
        $request->avatar_url->storeAs('avatars', $fileName, 'public');
    
        $user = auth()->user();

        // $user->update(['avatar_url' => '/storage/avatars/'.$fileName]);
        $user->update(['avatar_url' => $fileName]);

        return new ProfileResource($user);
    }

}
