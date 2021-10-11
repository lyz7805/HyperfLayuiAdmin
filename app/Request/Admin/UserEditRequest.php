<?php

declare(strict_types=1);

namespace App\Request\Admin;

use Hyperf\Validation\Request\FormRequest;

class UserEditRequest extends FormRequest
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
            'id' => 'required|integer|min:1|exists:admin_user,id',
            'username' => 'sometimes|required|alpha_dash',
            'name' => 'sometimes|required|alpha_dash',
            'password' => 'sometimes|required|alpha_dash|between:5,16',
            'avatar' => 'sometimes|required|image'
        ];
    }
}
