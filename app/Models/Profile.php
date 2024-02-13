<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\ProfileID;

class Profile extends Model
{
    protected $table      = 'profile';
    protected $fillable   = [
        'name',
        'status',
    ];

    public function menus()
    {
        return $this->hasMany(MenuProfile::class, 'profile_id', 'id');
    }


    public function getMenu()
    {
        $fathers = [];
        $children = [];
        foreach ($this->menus->sortBy('menu.orden') as $menu_profile) { 
            if($menu_profile->menu->father_id == null) {
                $father = (object)[
                    "id" => $menu_profile->menu->id,
                    "title" => $menu_profile->menu->title,
                    "icon" => $menu_profile->menu->icon,
                    "path" => $menu_profile->menu->path,
                    "children" => []
                ];
                $fathers[] = $father;
            }else{
                $children[] = $menu_profile->menu;
            }
        }

        foreach ($fathers as $father) {
            foreach ($children as $son) {
                if($son->father_id == $father->id) array_push($father->children, $son);
            }
        }
        return $fathers;
    }

    public static function getProfiles()
    {
        $profile_id = session('profile_id');

        if($profile_id == ProfileID::SUPER_ADMIN) { //SUPER ADMIN
            return Profile::all()->where('status', 1);
        }
        if($profile_id == ProfileID::RED_AUDITOR) { //COORDINADOR GENERAL DE RED
            return Profile::all()
            ->whereIn('id', [ProfileID::SEGMENT_LEADER, ProfileID::LEADER])
            ->where('status', 1);
        }
        if($profile_id == ProfileID::SEGMENT_LEADER) { //LIDER DE SEGMENTO
            return Profile::all()
            ->whereIn('id', [ProfileID::LEADER, ProfileID::ASSISTANT])
            ->where('status', 1);
        }
        if($profile_id == ProfileID::LEADER) {
            return Profile::all()
            ->where('id', [ProfileID::ASSISTANT])
            ->where('status', 1);
        }
        return [];
    }

}
