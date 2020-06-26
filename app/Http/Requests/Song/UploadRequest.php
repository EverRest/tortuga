<?php

namespace App\Http\Requests\Song;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UploadRequest
 *
 * @package App\Http\Requests\Song
 */
class UploadRequest extends FormRequest
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
            'file' => 'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav'
        ];
    }
}
