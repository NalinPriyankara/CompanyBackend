<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

class ProjectRequest extends FormRequest
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
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string',
            'status'      => 'required|string|max:50',
            'image'       => [
                'nullable',
                function ($attribute, $value, $fail) {
                    // Allow a string path (e.g. existing storage path) or an uploaded file
                    if (is_string($value)) {
                        return;
                    }

                    if ($value instanceof UploadedFile) {
                        $validator = Validator::make([$attribute => $value], [$attribute => 'image|mimes:jpg,jpeg,png,webp']);
                        if ($validator->fails()) {
                            $fail($validator->errors()->first($attribute));
                        }
                        return;
                    }

                    $fail('The '.$attribute.' must be an uploaded image or a string path.');
                },
            ],
        ];
    }
}
