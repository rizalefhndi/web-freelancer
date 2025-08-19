<?php

namespace App\Http\Requests\Dashboard\Profile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

use Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'max:255'
            ],
            'email' => [
                'required',
                'string',
                'max:255',
                'email',
                Rule::unique('users', 'email')->ignore(Auth::id()) // Fix: gunakan ignore() method
            ],
        ];
    }
}
