<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\ProfileID;

class Profile extends Model
{
    protected $table      = 'Profile';
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
                $father = $menu_profile->menu;
                $father->children = [];
                $fathers[] = $father;
            }else{
                $children[] = $menu_profile->menu;
            }
        }

        foreach ($fathers as $father) {
            foreach ($children as $son) {
                if($son->father_id == $father->id) $father->children[] = $son;
            }
        }
        return $fathers;
    }

    public function getProfiles()
    {
        $profile_id = session('profile_id');

        if($profile_id == ProfileID::SUPER_ADMIN) { //SUPER ADMIN
            return Profile::all()->where('status', 1);
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
    }

}
