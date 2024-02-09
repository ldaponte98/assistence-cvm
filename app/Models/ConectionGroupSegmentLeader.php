<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\PeopleType;
use Illuminate\Support\Facades\DB;

class ConectionGroupSegmentLeader extends Model
{
    protected $table      = 'conection_group_segment_leaders';

    public function conection_group()
    {
        return $this->belongsTo(ConectionGroup::class, 'conection_group_id', 'id');
    }

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id', 'id');
    }

    public static function getIdsConectionGroup($people_type, $people_id)
    {
        $table = $people_type == PeopleType::LEADER ? "conection_group_leaders" : "conection_group_segment_leaders";
        $result = DB::select("SELECT conection_group_id FROM $table WHERE people_id = " . $people_id);
        $ids = [];
        foreach ($result as $item) {
            $ids[] = $item->conection_group_id;
        }
        return $ids;
    }
}
