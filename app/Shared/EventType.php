<?php
namespace App\Shared;

class EventType
{
    const EXTERNAL = "EXTERNAL";
    const CONECTIONS_GROUP = "CONECTIONS_GROUP";
    const WELCOME = "WELCOME";

    const LIST = [
        ["code" => EventType::CONECTIONS_GROUP, "text" => "Grupo de conexiones"],
        ["code" => EventType::WELCOME, "text" => "Bienvenida"],
        ["code" => EventType::EXTERNAL, "text" => "Externo"]
    ];

    public static function get($code)
    {
        foreach (EventType::LIST as $type) {
            if($type["code"] == $code) return $type["text"];
        }
        return "Desconocido";
    }
}