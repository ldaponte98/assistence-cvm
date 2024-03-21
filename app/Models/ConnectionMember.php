<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectionMember extends Model
{
    protected $table      = 'connections_member';

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id', 'id');
    }
}
