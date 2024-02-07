<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConectionGroupAssistant extends Model
{
    protected $table      = 'conection_group_assistant';

    public function conection_group()
    {
        return $this->belongsTo(ConectionGroup::class, 'conection_group_id', 'id');
    }

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id', 'id');
    }
}
