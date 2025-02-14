<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieStoreRequest extends FormRequest
{

    public function authorize()
    {
        return $this->user()->is_admin;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:movies',
            'description' => 'required|string',
            'thumbnail' => 'required|url',
            'video_url' => 'required|url',
            'release_date' => 'required|date',
            'genre' => 'required|string|max:255',
        ];
    }
}
