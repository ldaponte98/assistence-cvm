<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Shared\PeopleType;
use Exception;

class ConectionGroup extends Model
{
    protected $table      = 'conection_group';

    protected $fillable = [
        'name',
        'red',
        'initial_age',
        'final_age',
        'check_years',
        'check_neighborhoods',
        'check_couples',
        'leader_id',
        'leader_segment_id',
        'status'
    ];

    public function getIdsPeopleLeader($type)
    {
        $table = $type == PeopleType::LEADER ? "conection_group_leaders" : "conection_group_segment_leaders";
        $result = DB::select("SELECT people_id FROM $table WHERE conection_group_id = " . $this->id);
        $ids = [];
        foreach ($result as $item) {
            $ids[] = $item->people_id;
        }
        return $ids;
    }

    public function getIdsPeopleAssistants()
    {
        $result = DB::select("SELECT people_id FROM conection_group_assistant WHERE conection_group_id = " . $this->id);
        $ids = [];
        foreach ($result as $item) {
            $ids[] = $item->people_id;
        }
        return $ids;
    }

    public function getAssistants()
    {
        return People::whereIn('id', $this->getIdsPeopleAssistants())->get();
    }

    public function getLeaders()
    {
        return People::whereIn('id', $this->getIdsPeopleLeader(PeopleType::LEADER))->get(['id']);
    }

    public function getLeadersFull()
    {
        return People::whereIn('id', $this->getIdsPeopleLeader(PeopleType::LEADER))->get();
    }

    public function getSegmentLeaders()
    {
        return People::whereIn('id', $this->getIdsPeopleLeader(PeopleType::SEGMENT_LEADER))->get(['id']);
    }

    public function isSegmentLeader($people_id)
    {
        foreach ($this->getIdsPeopleLeader(PeopleType::SEGMENT_LEADER) as $id_valid) {
            if($people_id == $id_valid) return true;
        }
        return false;
    }

    public function isLeader($people_id)
    {
        foreach ($this->getIdsPeopleLeader(PeopleType::LEADER) as $id_valid) {
            if($people_id == $id_valid) return true;
        }
        return false;
    }

    public function validate()
    {
        if($this->check_years == null) $this->check_years = 0;
        if($this->check_neighborhoods == null) $this->check_neighborhoods = 0;
        if($this->check_couples == null) $this->check_couples = 0;

        if($this->check_years == 1 and ($this->initial_age == null or $this->final_age == null)){
            throw new Exception("Para esta configuración la edad inicial y final son obligatorias.");
        }

        if($this->check_years == 1 and $this->initial_age > $this->final_age){
            throw new Exception("La edad inicial no puede ser mayor a la final.");
        }
        $validation = ConectionGroup::where('name', $this->phone)->where('red', $this->name);
        if($this->id != null) $validation->where('id', '<>', $this->id);
        $validation = $validation->first();
        if($validation != null){
            throw new Exception("El nombre del grupo ya esta asociado a la red.");
        }
    }
}
