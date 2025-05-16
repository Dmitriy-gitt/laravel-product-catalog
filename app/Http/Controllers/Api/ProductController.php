<?php

namespace App\Http\Controllers\Api;

use App\Contracts\IProductServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductIndexRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        private readonly IProductServices $productServices
    )
    {
    }
    public function index(ProductIndexRequest $request): JsonResponse
    {
        $products = $this->productServices->getProducts(
            $request->toDTO()
        );

        return response()->json(ProductResource::collection($products));
    }
}
