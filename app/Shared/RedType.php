<?php
namespace App\Shared;

class RedType
{
    const RELEVAT_GENERATION = "RELEVAT_GENERATION";
    const AUTHENTIC_WOMEN = "AUTHENTIC_WOMEN";
    const INSEPARABLE = "INSEPARABLE";
    const CONQUERORS = "CONQUERORS";
    const KIDS = "KIDS";
    const CONNECTIONS = "CONNECTIONS";
    const GUACOCHE = "GUACOCHE";

    const LIST = [
        ["code" => RedType::RELEVAT_GENERATION, "text" => "Generación relevante"],
        ["code" => RedType::AUTHENTIC_WOMEN, "text" => "Mujeres autenticas"],
        ["code" => RedType::INSEPARABLE, "text" => "Inseparables"],
        ["code" => RedType::CONQUERORS, "text" => "Conquistadores"],
        ["code" => RedType::KIDS, "text" => "IgleKids"],
        ["code" => RedType::CONNECTIONS, "text" => "Conexiones"],
        ["code" => RedType::GUACOCHE, "text" => "Guacoche"]
    ];

    public static function get($code)
    {
        foreach (RedType::LIST as $type) {
            if($type["code"] == $code) return $type["text"];
        }
        return "No aplica";
    }
}