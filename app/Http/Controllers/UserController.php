<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\BarberServices;
use App\Models\User;
use App\Models\UserAppointment;
use App\Models\UserFavorite;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd;
use Intervention\Image\Drivers\Gd\Driver;

use function Laravel\Prompts\select;

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

    public function toggleFavorite(Request $request) {
        $array = ['error' => ''];
        $user = Auth::user();

        $id_barber = $request->input('barber');

        $barber = Barber::find($id_barber);

        if($barber) {
            $fav = UserFavorite::select()
            ->where('id_user', $user->id)
            ->where('id_barber', $id_barber)->count();

            if($fav) {
                
                $fav->delete();
                $array['have'] = false;  
            }else {
                $newFav = new UserFavorite();
                $newFav->id_user = $user->id;
                $newFav->id_barber = $id_barber;
                $newFav->save();
                $array['have'] = true;
            }
        }else{
            $array['error'] = 'Barbeiro inexistente';
        }
        return $array;
    }
    public function getFavorites()
    {
        $array = ['error' => '', 'list' => []];
        $user = Auth::user();

        $favs = UserFavorite::where('id_user', $user->id)->get();

        foreach ($favs as $fav) {
            $barber = Barber::find($fav->id_barber);
            if ($barber) {
                $barber->avatar = url('media/avatars/' . $barber->avatar);
                $array['list'][] = $barber;
            }
        }

        return $array;
    }

    public function getAppointments() {
        $array = ['error'=>'', 'list' => []];
        $user = Auth::user();

        $apps = UserAppointment::where('id_user', $user->id)->orderBy('ap_datetime', 'DESC')->get();

        if($apps) {
            foreach($apps as $app) {

                $barber = Barber::find($app['id_barber']);
                $barber['avatar'] = url('media/avatars',$barber['avatar']);

                $service = BarberServices::find($app['id_service']);

                $array['list'][] = [
                    'id' => $app['id'],
                    'ap_datetime' => $app['ap_datetime'],
                    'barber' => $barber,
                    'service' => $service
                ];

            }
        }
        return $array;
    }

    public function update(Request $request) {
        $array = ['error'=> ''];
        $user = Auth::user();
        $rules = [
            'name' => 'min:2',
            'email' => 'email|unique:users',
            'password' => 'confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if($validator->fails()){
            $array = $validator->messages();
            return $array;
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        
        $userAlter = User::find($user->id);

        if($name) {
            $userAlter->name = $name;
        }
        if($email) {
            $userAlter->email = $email;
        }
        if($password) {
            $userAlter->password = password_hash($password, PASSWORD_DEFAULT);
        }
        $userAlter->save();

        return $array;
    }

    public function updateAvatar(Request $request) {
        $array = ['error' => ''];
        $user = Auth::user();

        $rules = [
            'avatar' => 'required| image|mimes:png,jpg,jpeg'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            $array['error'] = $validator->messages();
            return $array;
        }

        $avatar = $request->file('avatar');

        $dest = public_path('/media/avatars');
        $avatarName = md5(time().rand(0,9999)).'.jpg';

        $img = ImageManager::usingDriver(Driver::class)->decode($avatar->getRealPath());
        $img->cover(300,300)->save($dest.'/'.$avatarName);

        $userAlter = User::find($user->id);

        return $array;
    }

}
