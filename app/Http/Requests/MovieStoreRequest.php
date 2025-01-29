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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'required|url',
            'release_date' => 'required|date',
            'genre' => 'required|string|max:255',
        ];
    }
}
