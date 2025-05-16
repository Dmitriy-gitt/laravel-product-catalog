<?php

namespace App\Http\Requests;

use App\Dto\ProductIndexDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Validation\Validator;

class ProductIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'properties' => 'sometimes|array',
            'properties.*' => 'required|array|min:1',
            'properties.*.*' => 'required|string|filled'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    public function toDTO(): ProductIndexDto
    {
        $properties = $this->input('properties', []);
        $filteredProperties = [];

        foreach ($properties as $propertyName => $values) {
            $filteredValues = array_filter((array)$values, fn($value) => !empty($value));
            if (!empty($filteredValues)) {
                $filteredProperties[$propertyName] = $filteredValues;
            }
        }

        return new ProductIndexDto(
            properties: $filteredProperties
        );
    }
}
