<?php

declare(strict_types=1);

namespace App\Request\Admin;

use App\Model\AdminRole;
use Hyperf\Validation\Request\FormRequest;

class RoleEditRequest extends FormRequest
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
            'id' => 'required|integer|min:1|exists:admin_role,id',
            'name' => 'required|alpha_dash|unique:admin_role,name,' . $this->input('id') . ',id',
            'state' => 'sometimes|required|integer|between:0,1'
        ];
    }
}
