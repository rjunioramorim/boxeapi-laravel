<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Clients\ProfileResource;
use App\Models\User;

class GetProfileController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        $user = User::with(['client.plan'])->where('id', $user->id)->first();

        return new ProfileResource($user);
    }
}
