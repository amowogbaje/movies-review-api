<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovieUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->is_admin;
    }

    public function rules()
    {
        $movieId = $this->route('movie') ? $this->route('movie')->id : null;

        return [
            'title' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('movies')->ignore($movieId),
            ],
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|url',
            'video_url' => 'nullable|url',
            'release_date' => 'nullable|date',
            'genre' => 'nullable|string|max:255',
        ];
    }
}
