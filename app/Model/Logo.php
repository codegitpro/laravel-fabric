<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    protected $guarded = ['id'];

    public function getBrandLogoAttribute($value){
        $imageUrl = url('/public/storage/' . $this->attributes['brand_logo']);
        return  str_replace('\\', '/', $imageUrl);

    }
}
