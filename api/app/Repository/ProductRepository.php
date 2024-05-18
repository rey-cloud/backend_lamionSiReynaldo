<?php

namespace App\Repository;

use App\Interface\Repository\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::query(); // This returns a query builder instance
    }

    public function getById(int $id)
    {
        try {
            return Product::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw new \Exception("Product with ID $id not found", 404);
        }
    }

    public function create(object $data)
    {
        return Product::create((array) $data);
    }

    public function update(int $id, object $data)
    {
        $product = $this->getById($id);
        $product->update((array) $data);

        return $product;
    }

    public function delete(int $id)
    {
        $product = $this->getById($id);
        $product->delete();

        return $product;
    }
}
