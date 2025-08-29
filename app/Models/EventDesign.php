<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDesign extends Model
{
    protected $table      = 'event_design';

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
