<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class User extends Model
{
    protected $table      = 'user';
    protected $fillable = [
        'profile_id',
        'people_id',
        'username',
        'red',
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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function validate()
    {
        $validation = User::where('username', $this->username);
        if($this->id != null) $validation->where('id', '<>', $this->id);
        $validation = $validation->first();
        if($validation != null){
            throw new Exception("El nombre de usuario ya se encuentra registrado");
        }
    }

    public static function validRed($compare)
    {
        $red = session("red");
        if($red == null) return true;
        return $red == $compare;
    }
}
