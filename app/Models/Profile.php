<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        foreach ($this->menus as $menu_profile) { 
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

        if($profile_id == 1) { //SUPER ADMIN
            return Profile::all()->where('status', 1);
        }
        if($profile_id == 2) { //LIDER DE SEGMENTO
            return Profile::all()
            ->whereIn('id', [3, 4])
            ->where('status', 1);
        }
        if($profile_id == 3) { //LIDER
            return Profile::all()
            ->where('id', [4])
            ->where('status', 1);
        }
    }

}
