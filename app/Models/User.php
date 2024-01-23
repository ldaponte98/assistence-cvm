<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table      = 'user';
    protected $fillable = [
        'profile_id',
        'people_id',
        'username',
        'password',
        'status',
    ];
    
    public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
}
