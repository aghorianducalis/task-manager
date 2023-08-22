<?php

namespace App\Http\Requests;

use App\Models\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
                'required',
                'min:0',
                'max:255',
                'unique:tasks,title',
            ],
            'description' => [
                'required',
                'min:0',
                'max:10000',
            ],
            'status'      => 'required|in:' . implode(',', TaskStatusEnum::getStatusValues()),
            'due_date'    => 'required|date',
        ];
    }
}
