<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class ImageAddWatermarkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'radio'=>'required'
        ];
    }
    public function messages()
    {
        return [
          'required'=>'Watermark is not selected.'
        ];
    }
}
