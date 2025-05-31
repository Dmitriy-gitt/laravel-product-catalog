<?php

namespace App\Services;

use App\Contracts\IProductServices;
use App\Http\Requests\ProductIndexRequest;
use App\Jobs\CacheProducts;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ProductServices implements IProductServices
{
    public function getProducts(ProductIndexRequest $dto): LengthAwarePaginator
    {
        try {
            $cacheKey = $this->generateCacheKey($dto);

            if ($cached = Redis::command('GET', [$cacheKey])) {
                return unserialize($cached);
            }

            $products = $this->buildQuery($dto)->paginate(40);

            CacheProducts::dispatch($cacheKey, $products);

            return $products;

        } catch (\Exception $e) {
            Log::error('ProductService error: '.$e->getMessage());
            return Product::query()->paginate(0);
        }
    }

    protected function buildQuery(ProductIndexRequest $dto)
    {
        $query = Product::with('properties');

        if ($dto->properties) {
            foreach ($dto->properties as $propertyName => $values) {
                $query->whereHas('properties', function($q) use ($propertyName, $values) {
                    $q->where('name', $propertyName)
                        ->whereIn('value', (array)$values);
                });
            }
        }

        return $query;
    }

    protected function generateCacheKey(ProductIndexRequest $dto): string
    {
        return 'products:' . 555;
    }
}
