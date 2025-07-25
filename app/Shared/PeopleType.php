<?php
namespace App\Shared;

class PeopleType
{
    const PASTOR = "PASTOR";
    const SEGMENT_LEADER = "SEGMENT_LEADER";
    const LEADER = "LEADER";
    const MENTOR = "BELIEVER";
    const FOLLOWER = "FOLLOWER";
    const NEW_BELIEVER = "NEW_BELIEVER";
    const CLINIC_PATIENT = "CLINIC_PATIENT";
    const PARTICIPANT = "PARTICIPANT";

    const LIST = [
        ["code" => PeopleType::NEW_BELIEVER, "text" => "Nuevo creyente"],
        ["code" => PeopleType::FOLLOWER, "text" => "Discipulo"],
        ["code" => PeopleType::MENTOR, "text" => "Mentor"],
        ["code" => PeopleType::LEADER, "text" => "Lider"],
        ["code" => PeopleType::SEGMENT_LEADER, "text" => "Lider de segmento"],
        ["code" => PeopleType::CLINIC_PATIENT, "text" => "Paciente de clínica"],
        ["code" => PeopleType::PASTOR, "text" => "Pastor"],
        ["code" => PeopleType::PARTICIPANT, "text" => "Participante normal"]
    ];

    public static function get($code)
    {
        foreach (PeopleType::LIST as $type) {
            if($type["code"] == $code) return $type["text"];
        }
        return "Desconocido";
    }
}