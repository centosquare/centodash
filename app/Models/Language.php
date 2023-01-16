<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory;


    protected $table='languages';
    protected $fillable=['name','code'];

    public function setNameAttribute($value){
        $this->attributes['name'] = ucwords($value);
    }

    public function setCodeAttribute($value){
        $this->attributes['code'] = Str::lower($value);
    }
}
