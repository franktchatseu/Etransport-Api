<?php

namespace App\Models\Actuality;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    
    public function sousMenu() {
        return $this->belongsToMany('App\Models\Actuality\Sub_Menu','sub_menus','menu_id');
    }

    public function attributeMenu() {
        return $this->belongsToMany('App\Models\Actuality\Attribute_Menu', 'attribute_menus' ,'attribute_id','menu_id');
    }

    // public function roles() {
    //     return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
    // }

    // public function groups() {
    //     return $this->belongsToMany('App\Group', 'user_groups', 'user_id', 'group_id');
    // }

}
