<?php

namespace App\DTO;

use App\Enums\ProductSort;
use App\Http\Requests\ProductsIndexRequest;

final readonly class ProductFilterData
{
    public function __construct(
        public ?string $q = null,
        public ?float $priceFrom = null,
        public ?float $priceTo = null,
        public ?int $categoryId = null,
        public ?bool $inStock = null,
        public ?float $ratingFrom = null,
        public ?ProductSort $sort = null,
    ) {}

    public static function fromRequest(ProductsIndexRequest $request): self
    {
        $data = $request->validated();

        return new self(
            q: $data['q'] ?? null,
            priceFrom: isset($data['price_from']) ? (float) $data['price_from'] : null,
            priceTo: isset($data['price_to']) ? (float) $data['price_to'] : null,
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null,
            inStock: $data['in_stock'] ?? null,
            ratingFrom: isset($data['rating_from']) ? (float) $data['rating_from'] : null,
            sort: isset($data['sort']) ? ProductSort::from($data['sort']) : null,
        );
    }
}
