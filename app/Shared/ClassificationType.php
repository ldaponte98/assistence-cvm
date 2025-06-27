<?php
namespace App\Shared;

class ClassificationType
{
    const NEWS = "NEWS";
    const NEWS_IN_RED = "NEWS_IN_RED";
    const OLDS = "OLDS";
    const OLDS_IN_RED = "OLDS_IN_RED";

    const LIST = [
        ["code" => ClassificationType::NEWS, "text" => "Nuevos"],
        ["code" => ClassificationType::NEWS_IN_RED, "text" => "Nuevos por red"],
        ["code" => ClassificationType::OLDS, "text" => "Antiguos"],
        ["code" => ClassificationType::OLDS_IN_RED, "text" => "Antiguos por red"]
    ];

    public static function get($code)
    {
        foreach (ClassificationType::LIST as $type) {
            if($type["code"] == $code) return $type["text"];
        }
        return "Desconocido";
    }
}