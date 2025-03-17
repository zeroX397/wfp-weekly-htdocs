<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected $table = "foods";
    function category()
    {
        return $this->belongsTo(Category::class);
    }
}

// protected $table = 'soal'; ==> nama table di DB. Default -> plural nama model

// protected $primaryKey = 'soal_id'; ==> nama kolom PK di DB. Default -> "id"
// public $incrementing = false; ==> PK-nya AI atau tdk. Default -> Yes
// protected $keyType = 'string'; ==> tipe data PK. Default -> Big INT
// public $timestamps = true; ==> apakah ada created_at dan updated_at? Default -> true
// const CREATED_AT = 'creation_date'; ==> nama kolom created_at. Default -> "created_at"
// const UPDATED_AT = 'last_update'; ==> nama kolom created_at. Default -> "created_at"