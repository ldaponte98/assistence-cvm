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

    public function getLeaders()
    {
        return People::whereIn('id', $this->getIdsPeopleLeader(PeopleType::LEADER))->get(['id']);
    }

    public function getSegmentLeaders()
    {
        return People::whereIn('id', $this->getIdsPeopleLeader(PeopleType::SEGMENT_LEADER))->get(['id']);
    }

    public function validate()
    {
        $validation = ConectionGroup::where('name', $this->phone)->where('red', $this->name);
        if($this->id != null) $validation->where('id', '<>', $this->id);
        $validation = $validation->first();
        if($validation != null){
            throw new Exception("El nombre del grupo ya esta asociado a la red.");
        }
    }
}
