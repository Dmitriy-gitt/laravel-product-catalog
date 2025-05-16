<?php

namespace App\Services;

use App\Contracts\IProductServices;
use App\Http\Requests\ProductIndexRequest;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ProductServices implements IProductServices
{
    public function getProducts(ProductIndexRequest $dto): LengthAwarePaginator
    {
        try{
            $query = Product::with('properties');

            if ($dto->properties) {
                foreach ($dto->properties as $propertyName => $values) {
                    $query->whereHas('properties', function($q) use ($propertyName, $values) {
                        $q->where('name', $propertyName)
                            ->whereIn('value', (array)$values);
                    });
                }
            }

            return $query->paginate(40);
        } catch (\Exception $e) {
            Log::error('Ошибка ProductServices->getProducts() ' . $e->getMessage());
            return Product::query()->paginate(0);
        }
    }
}
