<?php

namespace App\Features\Products\Queries;

class ListProductVariantQuery
{
    private int $limit;
    private int $offset;

    public function __construct(int $limit, int $offset)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public static function create(int $limit, int $offset): self
    {
        return new self($limit, $offset);
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
