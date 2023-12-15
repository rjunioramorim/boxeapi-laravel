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
    public function __invoke(Request $request)
    {
        
      



         // dd($request->avatar_url);
         $avatarUrl = auth()->user()->avatar_url;
         if ($avatarUrl != null && $avatarUrl != 'images/avatar_default.jpg') {
             Storage::delete('public/avatars/' . auth()->user()->avatar_url);
         }
 
         $image = $request->avatar_url;
         
         
         if($request->avatar_url !=null) {
             $image = str_replace('blob:', '', $request->avatar_url);
             Storage::disk('local')->put('public/avatars/', file_get_contents($image));
         }
 
         // $dest_image = 'public/' . Customer::getUserAvatarPath($newCustomer->id, $requestData['avatar_filename']);
 
         // $requestData['avatar_blob']= str_replace('blob:','',$requestData['avatar_blob']);
         // Storage::disk('local')->put($dest_image, file_get_contents($requestData['avatar_blob']));
        
         $user = auth()->user();
 
         return new ProfileResource($user);
    }
}
