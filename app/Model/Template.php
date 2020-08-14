<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $guarded = ['id'];

    public function getPreviewImageAttribute($value){
        if(!empty($this->attributes)){
            $imageUrl = url('public/storage/' . $this->attributes['preview_image']);
            return  str_replace('\\', '/', $imageUrl);
        }
        return '';
    }

    public function getBackgroundImageAttribute($value){
        if(!empty($this->attributes)){
            $imageUrl = url('public/storage/' . $this->attributes['background_image']);
            return  str_replace('\\', '/', $imageUrl);
        }
        return '';
    }

    public function getProofImageAttribute($value){
        if(!empty($this->attributes)){
            $imageUrl = url('public/storage/' . $this->attributes['proof_image']);
            return  str_replace('\\', '/', $imageUrl);
        }
        return '';
    }
}
