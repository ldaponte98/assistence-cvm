<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class People extends Model
{
    protected $table      = 'people';

    protected $fillable = [
        'document',
        'type',
        'fullname',
        'lastname',
        'gender',
        'phone',
        'email',
        'status'
    ];

    public function names()
    {
        return $this->fullname . " " . $this->lastname;
    }

    public function getAvatar()
    {
        return $this->gender == 'F' ? asset('images/women.png') : asset('images/men.png');
    }

    public function validate()
    {
        $validation = People::where('phone', $this->phone);
        if($this->id != null) $validation->where('id', '<>', $this->id);
        $validation = $validation->first();
        if($validation != null){
            throw new Exception("El teléfono ya se encuentra registrado.");
        }
        $validation = People::where('document', $this->document);
        if($this->id != null) $validation->where('id', '<>', $this->id);
        $validation = $validation->first();
        if($validation != null){
            throw new Exception("El número de identificación ya se encuentra asociado a otro registro.");
        }
        $validation = People::where('email', $this->email);
        if($this->id != null) $validation->where('id', '<>', $this->id);
        $validation = $validation->first();
        if($validation != null){
            throw new Exception("El correo electrónico ya se encuentra asociado a otro registro.");
        }
    }
}
