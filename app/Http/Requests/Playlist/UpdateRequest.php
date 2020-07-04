<?php

namespace App\Http\Requests\Playlist;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            "name"        => "sometimes|string|max:255",
            "description" => "sometimes|string",
            "songs"       => "required|array",
            "songs.*"     => "sometimes|numeric|exists:songs,id"
        ];
    }
}
