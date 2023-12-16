<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\Clients\ProfileResource;
use App\Models\User;
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
        $avatarUrl = auth()->user()->avatar_url;

        if ($avatarUrl != null || $avatarUrl != 'images/avatar_default.jpg') {
            Storage::delete('public/' . auth()->user()->avatar_url);
        }

        if ($request->hasFile('avatar_url')) {
            $image = $request->file('avatar_url');

            $fileName = uniqid('image_') . '.' . $image->getClientOriginalExtension();

            // Salva o arquivo no storage
            $image->storeAs('public', $fileName);

            // Pode retornar o caminho do arquivo salvo se necessário
            $user = User::where('id', auth()->user()->id)->first();
            $user->update(['avatar_url' => $fileName]);

            return new ProfileResource($user);
        }
        return response()->json(['error' => 'Nenhuma imagem enviada'], 400);
    }
}
