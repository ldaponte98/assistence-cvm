<?php
namespace App\Shared;
use Illuminate\Support\Facades\DB;

class Log
{
    public static function save($message)
    {
        DB::table('log')->insert(
            [
                'message' => $message, 
                'user_id' => session('id') ? session('id') : 0
            ]
        );
    }
}