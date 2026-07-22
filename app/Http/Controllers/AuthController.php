<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Mcp\Request;

class AuthController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['create', 'login']),
        ];
    }
    public function create(Request $request) {
            $array = ['error'=>''];
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if(!$validator->fails()) {
                $name = $request->inout('name');
                $email = $request->input('email');
                $password = $request->input('password');

                $emailExists = User::where('email', $email)->count();
                if($emailExists === 0) {
                    $hash =  password_hash($password, PASSWORD_DEFAULT);
                    $newUser = new User();
                    $newUser->name = $name;
                    $newUser->email = $email;
                    $newUser->password = $hash;
                    $newUser->save();

                    $token = Auth::attempt([
                        'email' => $email,
                        'password' => $password
                    ]);

                    if(!$token){
                        $array['error'] = 'Ocorreu um erro!';
                        return $array;
                    }

                } else {
                    $array['error'] = 'Email Já Cadastrado';
                    return $array;
                }

                $info = Auth::user();
                $array['data'] = $info;
                $array['token'] = $token;

            } else {
                $array['error'] = "Dados Incorretos";
            }
            return $array;
    }
}
