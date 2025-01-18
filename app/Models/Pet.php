<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    private int $id;
    private int $categoryId;
    private string $name;
    private array $photoUrls;
    private string $status;

    public function __construct(int $id, int $categoryId, string $name, array $photoUrls, string $status)
    {
        $this->setId($id);
        $this->setCategoryId($categoryId);
        $this->setName($name);
        $this->setPhotoUrls($photoUrls);
        $this->setStatus($status);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhotoUrls(): array
    {
        return $this->photoUrls;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setId(int $id): void
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException("Id must be a positive integer.");
        }
        $this->id = $id;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function setName(string $name): void
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("Name cannot be empty.");
        }
        $this->name = $name;
    }

    public function setPhotoUrls(array $photoUrls): void
    {
        $this->photoUrls = $photoUrls;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
