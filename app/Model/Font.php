<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Font extends Model
{
    protected $guarded = ['id'];

    /*public function getPathAttribute($value){
        $fontUrl = asset($this->attributes['path']);
        return  str_replace('\\', '/', $fontUrl);
    }*/
}
