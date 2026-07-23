<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api'),
            
        ];
    }

    public function read() {
        $user = Auth::user();
        $array = ['error' => ''];

        $info = $this->$user;
        $info['avatar'] = url('/media/avatars/'.$info['avatar']);
        $array['data'] = $info;
        

        return $array;
    }
}
