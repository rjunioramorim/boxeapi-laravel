<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\json;

class LogoutController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        
        $user->tokens()->delete();
        
        return response()->json([],204);
    }
}
