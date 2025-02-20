<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\EventType;
use App\Shared\RedType;
use App\Shared\ProfileID;

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

    public function conection_group()
    {
        return $this->belongsTo(ConectionGroup::class, 'conection_group_id', 'id');
    }

    public function validate()
    {
    }

    public function validForSettings()
    {
        $current = date('Y-m-d H:i:s'); 
        $end = date('Y-m-d H:i:s', strtotime($this->end . "+1 days"));
        return $this->start <= $current && $end >= $current;
    }

    public function validForAssistance($profile_id, $people_id)
    {
        if($profile_id == ProfileID::SUPER_ADMIN) return true;
        if ($this->type == EventType::CONECTIONS_GROUP) {
            $group = $this->conection_group;
            if($profile_id == ProfileID::SEGMENT_LEADER and $group->isSegmentLeader($people_id)) return true;
            if($profile_id == ProfileID::LEADER and $group->isLeader($people_id)) return true;
            if($profile_id == ProfileID::RED_AUDITOR and ($group->isLeader($people_id) or $group->isSegmentLeader($people_id))) return true;
        }
        return false;
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

    public function getDateInfo()
    {
        $current = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime($current . "-1 days"));
        $tomorrow = date('Y-m-d', strtotime($current . "+1 days"));
        $start = date('Y-m-d', strtotime($this->start));
        $info = "";
        if($start == $current) $info = "Hoy";
        if($start == $yesterday) $info = "Ayer";
        if($start == $tomorrow) $info = "Mañana";

        if ($info == "") {
            $timeStart = date('H:i', strtotime($this->start));
            $timeEnd = date('H:i', strtotime($this->end));
            $info = $start . " desde las $timeStart hasta las $timeEnd";
        }
        return $info;
    }

    public function getInfoType()
    {
        $text = "";
        if($this->type == EventType::CONECTIONS_GROUP){
            $text = $this->conection_group->name; 
        }
        return $text;
    }

    public function getTextType() {
        return EventType::get($this->type);
    }

    public function getTextRed() {
        return RedType::get($this->red);
    }
}