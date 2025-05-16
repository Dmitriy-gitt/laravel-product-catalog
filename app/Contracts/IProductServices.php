<?php

namespace App\Contracts;
use App\Http\Requests\ProductIndexRequest;
use Illuminate\Pagination\LengthAwarePaginator;

interface IProductServices
{
    public function getProducts(ProductIndexRequest $dto): LengthAwarePaginator;
}
