<?php

declare(strict_types=1);

namespace App\Request\Admin;

use Hyperf\Validation\Request\FormRequest;

class UserAddRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'username' => 'required|alpha_dash|unique:admin_user,username',
            'name' => 'required|alpha_dash',
            'password' => 'required|alpha_dash|between:5,16',
            'avatar' => 'sometimes|required|image'
        ];
    }
}
