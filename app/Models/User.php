<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table      = 'user';
    protected $fillable = [
        'profile_id',
        'tpeople_id',
        'username',
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

    public function getAvatar()
    {
        return $this->people->gender == 'F' ? asset('images/women.png') : asset('images/men.png');
    }
}
