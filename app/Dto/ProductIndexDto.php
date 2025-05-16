<?php

namespace App\Dto;

class ProductIndexDto extends \App\Http\Requests\ProductIndexRequest
{
    public function __construct(
        public readonly ?array $properties = null
    ) {}
}
