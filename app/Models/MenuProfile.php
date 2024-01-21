<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuProfile extends Model
{
    protected $table      = 'menu_profile';

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }
}
