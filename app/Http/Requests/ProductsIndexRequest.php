<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductsIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'price_from' => ['nullable', 'numeric', 'min:0'],
            'price_to' => ['nullable', 'numeric', 'min:0'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'in_stock' => ['nullable', 'boolean'],
            'rating_from' => ['nullable', 'numeric', 'between:0,5'],
            'sort' => ['nullable', Rule::in(['price_asc', 'price_desc', 'rating_desc', 'newest'])],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    protected function passedValidation(): void
    {
        $data = [];
        $casts = [
            'price_from' => 'float',
            'price_to' => 'float',
            'rating_from' => 'float',
            'category_id' => 'int',
            'per_page' => 'int',
        ];

        foreach ($casts as $field => $castType) {
            if (! $this->has($field)) {
                continue;
            }

            $data[$field] = match ($castType) {
                'float' => (float) $this->input($field),
                default => (int) $this->input($field),
            };
        }

        if ($this->has('in_stock')) {
            $data['in_stock'] = $this->boolean('in_stock');
        }

        if ($data !== []) {
            $this->merge($data);
        }
    }
}
