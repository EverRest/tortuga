<?php

namespace App\Http\Requests\Song;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateRequest
 *
 * @package App\Http\Requests\Song
 */
class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fileName' => 'sometimes|string|max:100',
            'title'    => 'sometimes|string|max:100',
            'artist'   => 'sometimes|string|max:100'
        ];
    }
}
