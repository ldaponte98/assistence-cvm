<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $table      = 'people';

    protected $fillable = [
        'document',
        'type',
        'fullname',
        'lastname',
        'type_id',
        'phone',
        'email',
        'status',
    ];

    public function names()
    {
        return $this->fullname . " " . $this->lastname;
    }
}
