<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\PeopleStatus;
use App\Shared\PeopleType;
use Exception;
use DateTime;

class People extends Model
{
    protected $table      = 'people';

    protected $hidden = ['created_by_id', 'created_at', 'updated_at'];

    protected $fillable = [
        'document',
        'type',
        'fullname',
        'lastname',
        'gender',
        'phone',
        'birthday',
        'email',
        'status',
        'attend_church'
    ];

    public function names()
    {
        return $this->fullname . " " . $this->lastname;
    }

    public function getAvatar()
    {
        if ($this->gender == 'F') return asset('images/women.png');
        if ($this->gender == 'M') return asset('images/men.png');
        return asset('images/logo.png');
    }

    public static function imageAvatar($gender)
    {
        if ($gender == 'F') return asset('images/women.png');
        if ($gender == 'M') return asset('images/men.png');
        return asset('images/logo.png');
    }

    public function getGender()
    {
        if ($this->gender == 'F') return "Mujer";
        if ($this->gender == 'M') return "Hombre";
        return $this->gender;
    }

    public function validate()
    {
        $validation = People::where('phone', $this->phone);
        if($this->id != null) $validation->where('id', '<>', $this->id);
        $validation = $validation->first();
        if($validation != null){
            throw new Exception("El teléfono ya se encuentra registrado.");
        }
        if($this->document != null and $this->document != ""){
            $validation = People::where('document', $this->document);
            if($this->id != null) $validation->where('id', '<>', $this->id);
            $validation = $validation->first();
            if($validation != null){
                throw new Exception("El número de identificación ya se encuentra asociado a otro registro.");
            }
        }

        if($this->email != null and $this->email != ""){
            $validation = People::where('email', $this->email);
            if($this->id != null) $validation->where('id', '<>', $this->id);
            $validation = $validation->first();
            if($validation != null){
                throw new Exception("El correo electrónico ya se encuentra asociado a otro registro.");
            }
        }

        if (PeopleType::get($this->type) == "Desconocido") {
            throw new Exception("El tipo de persona no es válido.");
        }
    }

    public static function getActives($types)
    {
        return People::all()
                    ->where('status', PeopleStatus::ACTIVE)
                    ->whereIn('type', $types);
    }

    public function getTextType(){
        return PeopleType::get($this->type);
    }

    public function getTextStatus(){
        return PeopleStatus::get($this->status);
    }

    public function getAge() {
        $date = new DateTime($this->birthday);
        $current = new DateTime();
        $diff = $current->diff($date);
        return $diff->y;
    }

    public function getConnectionGroups(){
        $relations = ConectionGroupAssistant::all()->where('people_id', $this->id);
        $result = [];
        foreach ($relations as $relation) {
            $result[] = (object) [
                "group" => $relation->conection_group,
                "assist" => $relation->status
            ];
        }
        return $result;
    }

    private static function compareDate($a, $b){
        return strtotime(trim($a->created_at)) < strtotime(trim($b->created_at));
    }

    public function getAssistances(){
        $relations = EventAssistance::all()->where('people_id', $this->id);
        $result = [];
        foreach ($relations as $relation) {
            $result[] = (object) [
                "event" => $relation->event,
                "assistance" => $relation,
                "created_at" => $relation->created_at
            ];
        }
        usort($result, array( $this, 'compareDate' ));
        return $result;
    }
}
