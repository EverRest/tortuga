<?php

namespace App\Http\Requests\Song;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateRequest
 *
 * @package App\Http\Requests\Song
 */
class CreateRequest extends FormRequest
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
            'fileName' => 'required|string|max:100',
            'title'    => 'required|string|max:100',
            'artist'   => 'required|string|max:100'
        ];
    }
}
