<?php

namespace App\Entity;

use Symfony\Component\Uid\Uuid;

class Category
{
    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    private Uuid $id;
    private string $name;
    private string $description;

    /**
     * @param string $name
     * @param string $description
     */
    public function __construct(string $name, string $description)
    {
        $this->id = Uuid::v4();
        $this->name = $name;
        $this->description = $description;
    }

    public static function create(string $name, string $description): Category
    {
        return new self($name, $description);
    }

    public function update(string $name, string $description): void
    {
        $this->name = $name;
        $this->description = $description;
    }

}