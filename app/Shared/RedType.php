<?php
namespace App\Shared;

class RedType
{
    const RELEVAT_GENERATION = "RELEVAT_GENERATION";
    const AUTHENTIC_WOMEN = "AUTHENTIC_WOMEN";
    const INSEPARABLE = "INSEPARABLE";

    const LIST = [
        ["code" => RedType::RELEVAT_GENERATION, "text" => "Generación relevante"],
        ["code" => RedType::AUTHENTIC_WOMEN, "text" => "Mujeres autenticas"],
        ["code" => RedType::INSEPARABLE, "text" => "Inseparables"]        
    ];

    public static function get($code)
    {
        foreach (RedType::LIST as $type) {
            if($type["code"] == $code) return $type["text"];
        }
        return "Desconocido";
    }
}