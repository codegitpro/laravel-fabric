<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mapping extends Model
{
    protected $guarded = ['id'];
    protected $fillable = ['product_name', 'product_slug', 'product_background', 'created_at', 'updated_at'];
    protected $appends = ['product_background_width', 'product_background_height'];

    public function getProductBackgroundAttribute($value){
        if(!empty($this->attributes)){
            $imageUrl = asset('storage/' . $this->attributes['product_background']);
            return  str_replace('\\', '/', $imageUrl);
        }
        return ''; 

    }

    public function getProductBackgroundWidthAttribute()
	{
	    if(!empty($this->attributes)){
    	    $imageUrl = public_path('storage/' . $this->attributes['product_background']);
            $imageUrl = str_replace('\\', '/', $imageUrl);
            $imageInfo = getimagesize ($imageUrl);
    	    return $imageInfo[0]; //add Custom Attribute
	    }
	    return ''; 
	}

	public function getProductBackgroundHeightAttribute()
	{
	    if(!empty($this->attributes)){
            $imageUrl = public_path('storage/' . $this->attributes['product_background']);
            $imageUrl = str_replace('\\', '/', $imageUrl);
            $imageInfo = getimagesize ($imageUrl);
    	    return $imageInfo[1]; //add Custom Attribute
	    }
	    return '';
	}
}
