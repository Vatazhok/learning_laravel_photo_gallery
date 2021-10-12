<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class ImageSharingImageRequest extends FormRequest
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
            'checkbox'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'required' => 'The pictures is not selected.'
        ];
    }
}
