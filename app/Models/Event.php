<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table      = 'event';
    protected $fillable = [
        'type',
        'red',
        'conection_group_id',
        'title',
        'start',
        'end',
        'status'
    ];

    public function validate()
    {
    }

    public function validForSettings()
    {
        $current = date('Y-m-d H:i:s'); 
        $end = date('Y-m-d H:i:s', strtotime($this->start . "+1 days"));
        return $this->start <= $current && $end >= $current;
    }

    public function getInfo()
    {
        $current = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime($current . "-1 days"));
        $tomorrow = date('Y-m-d', strtotime($current . "+1 days"));
        $start = date('Y-m-d', strtotime($this->start));
        $info = "";
        if($start == $current) $info = "Hoy";
        if($start == $yesterday) $info = "Ayer";
        if($start == $tomorrow) $info = "Mañana";
        return $info;
    }
}