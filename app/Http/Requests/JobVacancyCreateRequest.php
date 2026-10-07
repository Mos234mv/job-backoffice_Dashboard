<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // JobVacancy
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'salary' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'string', 'max:255'],
            'company_id' => ['required', 'string', 'max:255'],

        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.max' => 'Title must be at most 255 characters',
            'description.required' => 'Description is required',
            'description.max' => 'Description must be at most 255 characters',
            'location.required' => 'Location is required',
            'location.max' => 'Location must be at most 255 characters',
            'type.required' => 'Type is required',
            'type.max' => 'Type must be at most 255 characters',
            'salary.required' => 'Salary is required',
            'salary.max' => 'Salary must be at most 255 characters',
            'category_id.required' => 'Category is required',
            'category_id.max' => 'Category must be at most 255 characters',
            'company_id.required' => 'Company Name is required',
            'company_id.max' => 'Company Name must be at most 255 characters',
            'company_id.exists' => 'Company Name must be a valid company',

        ];
    }
}
