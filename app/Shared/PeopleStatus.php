<?php
namespace App\Shared;

class PeopleStatus
{
    const ACTIVE = "ACTIVE";
    const RETIRED = "RETIRED";

    const LIST = [
        ["code" => PeopleStatus::ACTIVE, "text" => "Activo", "class" => "success"],
        ["code" => PeopleStatus::RETIRED, "text" => "Retirado", "class" => "danger"]
    ];

    public static function get($code)
    {
        foreach (PeopleStatus::LIST as $type) {
            if($type["code"] == $code) return $type["text"];
        }
        return "Desconocido";
    }

    public static function getClass($code)
    {
        foreach (PeopleStatus::LIST as $type) {
            if($type["code"] == $code) return $type["class"];
        }
        return "";
    }
}