<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class ImagePostRequest extends FormRequest
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
            'image' => 'required|array|min:1',
            'image.*' => 'image|mimetypes:image/jpeg,image/png,image/jpg'
        ];
    }

    public function messages()
    {
        return [
            'image.*.image' => 'One or more of the files is not a picture.',
            'image.required' => 'The pictures is not selected.'
        ];
    }
}
