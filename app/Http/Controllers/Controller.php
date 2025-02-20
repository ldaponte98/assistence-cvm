<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\People;
use Exception;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function responseApi($error = false, $message = "OK", $data = null)
    {
        return response()->json([
            "error" => $error, 
            "message" => $message,
            "data" => $data
        ]);
    }

    public function getPeopleFromText($text_people, $return_object = false)
    {
        $array = explode("(Tel: ", $text_people);
        if(count($array) != 2) throw new Exception("El registro de base de datos enviado no es valido");
        $phone = explode(")", $array[1])[0];
        if($phone == null || $phone == "") throw new Exception("El registro de base de datos enviado no cumple la estructura definida");
        $people = People::where('phone', $phone)->first();
        if($people == null) throw new Exception("El registro de base de datos enviado no es valido segun su numero de telefono");
        return !$return_object ? $people->id : $people;
    }

    public function getDayWeek($date)
    {
        return strtolower(date('l', strtotime($date)));
    }

    public function isEmpty($var)
    {
        return $var == null || $var == "";
    }
}
