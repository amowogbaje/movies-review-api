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
            'required',
            'string',
            'max:255',
            Rule::unique('movies')->ignore($movieId),
        ],
        'description' => 'required|string',
        'thumbnail' => 'required|url',
        'video_url' => 'required|url',
        'release_date' => 'required|date',
        'genre' => 'required|string|max:255',
    ];
}
}
