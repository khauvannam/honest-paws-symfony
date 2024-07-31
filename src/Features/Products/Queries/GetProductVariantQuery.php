<?php

namespace App\Features\Products\Queries;

use App\Repository\ProductVariantRepository;
use App\Entity\Products\ProductVariant;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class GetProductVariantQuery
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function create(int $id): self
    {
        return new self($id);
    }

    public function getId(): int
    {
        return $this->id;
    }
}
