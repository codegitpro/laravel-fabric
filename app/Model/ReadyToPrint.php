<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReadyToPrint extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['original_url', 'ready_to_print_image', 'order_image_url'];

    protected $casts = [
        'used_font_map' => 'json',
    ];

    public function getImageAttribute($value){
        $imageUrl = asset('storage/' . $this->attributes['image']);
        return  str_replace('\\', '/', $imageUrl);
    }


    public function getOriginalUrlAttribute()
	{
	    return $this->attributes['image']; //add Custom Attribute
	}

    public function getReadyToPrintImageAttribute($value){
        $imageUrl = asset('storage/' . $this->attributes['image']);
        $imageUrl = str_replace(".svg", ".jpeg", $imageUrl);
        return  str_replace('\\', '/', $imageUrl);
    }

    public function getOrderImageUrlAttribute()
    {
        $imageUrl = asset('storage/' . $this->attributes['image']);
        $imageUrl = str_replace(".svg", '.png', $imageUrl);
        return  str_replace('\\', '/', $imageUrl);
    }

}
