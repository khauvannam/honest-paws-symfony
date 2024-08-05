<?php

namespace App\Entity\Categories;

use App\Repository\Categories\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: categoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;
    #[ORM\Column(type: 'string', length: 255)]
    private string $name;
    #[ORM\Column(type: 'string', length: 255)]
    private string $description;
    #[ORM\Column(type: 'string', length: 100)]
    private string $imgUrl;

    public function setId(string $id): Category
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): Category
    {
        $this->description = $description;
        return $this;
    }

    public function setImgUrl(string $imgUrl): Category
    {
        $this->imgUrl = $imgUrl;
        return $this;
    }

    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }

    public function getId(): string
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

    public function __construct(string $name, string $description, string $imgUrl)
    {
        $this->id = Uuid::v4()->toString();
        $this->name = $name;
        $this->description = $description;
        $this->imgUrl = $imgUrl;
    }

    public static function create(string $name, string $description, string $imgUrl): Category
    {
        return new self($name, $description, $imgUrl);
    }

    public function update(string $name, string $description): void
    {
        $this->name = $name;
        $this->description = $description;
    }
}
