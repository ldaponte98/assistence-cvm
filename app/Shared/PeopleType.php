<?php
namespace App\Shared;

class PeopleType
{
    const PASTOR = "PASTOR";
    const SEGMENT_LEADER = "SEGMENT_LEADER";
    const LEADER = "LEADER";
    const ASSISTANT = "ASSISTANT";

    public static function list()
    {
        $profile = session('profile_id');
        return [
            [ "value" => SUPERADMIN, "text" => "Super administrador" ]
        ];
    }
}