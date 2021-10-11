<?php

declare(strict_types=1);

namespace App\Request\Admin;

use Hyperf\Validation\Request\FormRequest;

class MenuRequest extends FormRequest
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
            'id' => 'sometimes|required|integer|min:1|exists:admin_menu,id',
            'parent_id' => 'required|integer|min:0',
            'title' => 'required|alpha_dash',
            'icon' => 'required',
            'href' => '',
            'target' => 'alpha_dash',
            'is_menu' => 'required|integer|between:0,1',
            'sort' => 'required|integer|min:0',
            'state' => 'integer|between:0,1'
        ];
    }
}
