<?php

namespace App\Http\Requests;

use App\Models\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'       => [
                'min:0',
                'max:255',
                Rule::unique('tasks', 'title')->ignore($this->route('id')),
            ],
            'description' => [
                'min:0',
                'max:10000',
            ],
            'status'      => 'in:' . implode(',', TaskStatusEnum::getStatusValues()),
            'due_date'    => 'date',
            'user_id'     => 'required|exists:users,id',
        ];
    }
}
