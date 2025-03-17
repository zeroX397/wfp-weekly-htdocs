<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    function food() {
        return $this -> hasMany(Food::class);
    }
}
