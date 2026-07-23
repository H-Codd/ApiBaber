<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\BarberAvailability;
use App\Models\BarberPhotos;
use App\Models\BarberServices;
use App\Models\BarberTestimonial;
use App\Models\UserAppointment;
use App\Models\UserFavorite;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
class BarberController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api'),
        ];
    }
/*
    public function createRandom() {
        $array = ['error' => ''];

        for($q = 0; $q < 15; $q++){
            $names = ['Lucas', 'Jeová', 'Mario', 'Pedro', 'Marcos', 'Junior', 'Gabriel'];
            $lastnames = ['Alves', 'Lacerda', 'Ribeiro', 'Diniz', 'Anta', 'Sloan', 'Souza'];

            $servicos = ['Corte', 'Secagem', 'Limpeza', 'Aparar', 'Depilação'];
            $servicos2 = ['Cabelo', 'Unhas', 'Pernas', 'Sombracelha', 'Nariz'];

            $depos = [
                'Integer vitae metus non justo scelerisque ultricies. Maecenas facilisis, tortor eget lobortis vestibulum, mi neque lacinia risus, eu convallis velit ligula sed ex. Phasellus elementum nisl nec purus porta ultricies. Vestibulum sed tempor tellus, a interdum erat. Vestibulum ante ipsum primis',
                'in faucibus orci luctus et ultrices posuere cubilia curae; Mauris hendrerit porttitor ultrices. Sed sit amet metus non urna tincidunt blandit. Curabitur quis ipsum congue, molestie nulla non, tincidunt neque. Ut interdum leo sed dolor posuere, ac vehicula dolor accumsan',
                'Pellentesque mauris elit, luctus ac mollis at, malesuada ut neque. Curabitur et vehicula massa. Sed augue lectus, consequat quis tincidunt ac, accumsan lobortis lorem. Morbi luctus, purus tristique pharetra tempor, tortor tortor posuere nisl, accumsan commodo odio arcu eget purus. Proin dignissim dui egestas, feugiat sapien a, congue lectus. Donec malesuada sagittis lacus quis suscipit. Integer orci leo, rutrum et diam id',
                'amet vel odio. Fusce vitae magna ex. Nam varius sem vel dui rutrum, nec commodo tortor placerat. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean quis molestie libero, quis tempor tortor. Vestibulum semper tortor ac nulla com',
                'Pellentesque mauris elit, luctus ac mollis at, malesuada ut neque. Curabitur et vehicula massa. Sed augue lectus, consequat quis tincidunt ac, accumsan lobortis lorem. Morbi luctus, purus tristique pharetra tempor, tortor tortor posuere nisl, accumsan commodo odio arcu eget purus. Proin dignissim dui egestas, feugiat sapien a, congue lectus. Donec malesuada sagittis lacus quis suscipit. Integer orci leo, rutrum et diam id',
                'amet vel odio. Fusce vitae magna ex. Nam varius sem vel dui rutrum, nec commodo tortor placerat. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean quis molestie libero, quis tempor tortor. Vestibulum semper tortor ac nulla com'
            ];

            $newBarber = new Barber();
            $newBarber->name = $names[array_rand($names)] . ' ' . $lastnames[array_rand($lastnames)];
            $newBarber->avatar = rand(1, 4) . '.png';
            $newBarber->stars = rand(2, 4) + (rand(0, 9) / 10); // e.g. 3.7
            $newBarber->latitude = '-23.5' . (rand(0, 9) / 1000); // e.g. -23.503
            $newBarber->longitude = '-46.6' . (rand(0, 9) / 1000); // e.g. -46.602
            $newBarber->save();

            $ns = rand(3,6);

            for($w = 0; $w < 4; $w++){
                $newBarberPhoto = new BarberPhotos();
                $newBarberPhoto-> id_barber = $newBarber->id;
                $newBarberPhoto-> url = rand(1,5). '.png';
                $newBarberPhoto-> save();
            }
            for($w = 0; $w<3; $w++){
                $newBarberService = new BarberServices();
                $newBarberService->id_barber = $newBarber->id;
                $newBarberService->name = $servicos[array_rand($servicos)]. ' de '.  $servicos2[array_rand($servicos2)];
                $newBarberService->price = rand(1, 99).'.'.rand(0,100);
                $newBarberService->save();

            }
            for($w = 0; $w<3; $w++){
                $newBarberTestimonial = new BarberTestimonial();
                $newBarberTestimonial->id_barber = $newBarber->id;
                $newBarberTestimonial->name = $names[array_rand($names)];
                $newBarberTestimonial->rate = rand(2, 4).'.'.rand(0,9);
                $newBarberTestimonial->body = $depos[array_rand($depos)];
                $newBarberTestimonial->save();
            }
            for ($r = 0; $r < 4; $r++) {
                $rAdd = rand(7, 10);
                $hours = [];

                for ($e = 0; $e < 8; $e++) {
                    $time = $e + $rAdd;
                    $hours[] = str_pad($time, 2, '0', STR_PAD_LEFT) . ':00';
                }

                $newBarberAvail = new BarberAvailability();
                $newBarberAvail->id_barber = $newBarber->id;
                $newBarberAvail->weekday = $r;
                $newBarberAvail->hours = implode(',', $hours);
                $newBarberAvail->save();
            }

            }
            return response()->json([
                'Barbers' => Barber::all(),
                'BarbersServices' => BarberServices::all(),
                'BarbersTestimonial' => BarberTestimonial::all(),
                'BarbersAvailability' => BarberAvailability::all()
            ]);
    }
*/
    public function list(Request $request) {
        $array = ['error' => ''];
        $offset = $request->input('offset',0); 


        $barbers = Barber::offset($offset)->limit(5)->get();

        foreach($barbers as $bkey => $bvalue) {
            $barbers[$bkey]['avatar'] = url('media/avatars/'.$barbers[$bkey]['avatar']);
        }

        $array['data'] = $barbers;
        $array['loc'] = 'São Paulo';
        
        return $array;
    }
    public function one(int $id) {
        $array = ['error' => ''];

        $barber = Barber::find($id);

        if($barber) {

            $user = Auth::user()->id;
            $barber['avatar'] = url('media/avatars/'.$barber['avatar']);
            $barber['favorited'] = false;
            $barber['photos'] = [];
            $barber['services'] = [];
            $barber['testimonials'] = [];
            $barber['available'] = [];

            $cFavorite = UserFavorite::where('id_user', $user)->where('id_barber', $barber->id)->count();
            if($cFavorite > 0) {
                $barber['favorited'] = true;
            }
            $barber['photos'] = BarberPhotos::select(['id', 'url'])->where('id_barber', $barber->id)->get();
            foreach($barber as $bpkey => $bpvalue) {
                $barber['photos'][$bpkey]['url'] = url('media/uploads/'.$barber['photos'][$bpkey]['url']);
            }

            $barber['services'] = BarberServices::select(['id', 'name', 'price'])->where('id_barber', $barber->id)->get();

            $barber['testimonials'] = BarberTestimonial::select(['id', 'name', 'rate', 'body'])->where('id_barber', $barber->id)->get();

            $avails = BarberAvailability::where('id_barber', $barber->id)->get();
            $availWeekdays = [];
            $availability = [];
            foreach($avails as $item){
                $availWeekdays[$item['weekday']] = explode(',', $item['hours']);
            }

            $appointments = [];
            $appQuery = UserAppointment::where('id_barber', $barber->id)
            ->whereBetween('ap_datetime', [
                date('Y-m-d'). '00:00:00 ',
                date('Y-m-d', strtotime('+20 days')).' 23:59:59'
            ])
            ->get();
            foreach($appQuery as $appItem) {
                $appointments[] = $appItem['ap_datetime'];
            }

            for($q = 0; $q < 20; $q++) {
                $timeItem = strtotime('+'.$q.'days');
                $weekday = date('w', $timeItem);

                if(in_array($weekday, array_keys($availWeekdays))){
                    $hours = [];

                    $dayItem = date('Y-m-d', $timeItem);

                    foreach($availWeekdays[$weekday] as $hourItem) {
                        $dayFormated = $dayItem. ' '. $hourItem. ':00';
                        if(!in_array($dayFormated, $appointments)) {
                            $hours[] = $hourItem;
                        }
                        }
                        if(count($hours) > 0) {
                            $availability[] = [
                                'date' => $dayItem,
                                'hours' => $hours
                            ];
                    }
                }
            }

            $barber['available'] = $availability;

            $array['data'] = $barber;
        } else{
            $array['error'] = 'Barbeiro não existe';
            return $array;
            }
        return $array;
    }
    public function setAppointment(int $id, Request $request) {
        $user = Auth::user();
        $array = ['error' => ''];

        $service = $request->input('service');
        $year = intval($request->input('year'));
        $month = intval($request->input('month'));
        $day = intval($request->input('day'));
        $hour = intval($request->input('hour'));

        $month = ($month < 10) ? '0'.$month : $month;
        $day = ($day < 10) ? '0'.$day : $day;
        $hour = ($hour < 10) ? '0'.$hour : $hour;

        $barberservice = BarberServices::select()->where('id', $service)->where('id_barber', $id)->first();
        if($barberservice){
            $apDate = $year.'-'.$month.'-'.$day.' '.$hour.':00:00';
            if(strtotime($apDate)> 0) {
                $apps = UserAppointment::select()->where('id_barber', $id)->where('ap_datetime', $apDate)->count();
                if($apps === 0) {
                    $weekday = date('w', strtotime($apDate));
                    $avail = BarberAvailability::select()->where('id_barber', $id)->where('weekday', $weekday)->first();
                    if($avail) {
                        $hours = explode(',', $avail['hours']);
                        if(in_array($hour.':00', $hours)){
                            $newApp = new UserAppointment();
                            $newApp->id_user = $user->id;
                            $newApp->id_barber = $id;
                            $newApp->id_service = $service;
                            $newApp->id_datetime = $apDate;
                            $newApp->save();
                        }else {
                            $array['error'] = 'Barbeiro não atende nesse Horário';
                        }
                    }else {
                        $array['error'] = 'Barbeiro não atende neste dia';
                    }
                }
            } else {
                $array['error'] = 'Data inválida';
            }
        }
        
        return $array;
    } 

}
