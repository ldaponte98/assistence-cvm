<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAssistanceQuestion extends Model
{
    protected $table      = 'event_assistance_question';

    protected $fillable = [
        'people_id',
        'code',
        'question',
        'answer',
        'status'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id', 'id');
    }
}
