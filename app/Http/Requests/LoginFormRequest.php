<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Worksome\RequestFactories\Concerns\HasFactory;

class LoginFormRequest extends FormRequest
{
    use HasFactory;

    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:dns'],
            'password' => ['required'],
        ];
    }
}
