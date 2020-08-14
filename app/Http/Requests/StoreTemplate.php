<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTemplate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'template_custom_id' => 'required',
            'preview_image' => 'required|max:10000|mimes:jpeg,bmp,png,svg',
            'background_image' => 'required|max:10000|mimes:jpeg,bmp,png,svg',
            'proof_image' => 'required|max:10000|mimes:jpeg,bmp,png,svg',
            'mapping_id' => 'required|exists:mappings,id',
            'font_id' => 'required|exists:fonts,id',
            'font_size' => 'required',
            'text_position' => 'required',
            'font_color' => 'required',
        ];
    }
}
