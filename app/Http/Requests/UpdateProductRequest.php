<?php

namespace App\Http\Requests;

class UpdateProductRequest extends StoreProductRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
         = parent::rules();
        foreach ($rules as $key => $rule) {
            array_unshift($rules[$key], 'sometimes');
        }
        return $rules;
    }
}
