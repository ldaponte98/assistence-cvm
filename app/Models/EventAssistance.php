<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAssistance extends Model
{
    protected $table      = 'event_assistance';

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id', 'id');
    }
}
