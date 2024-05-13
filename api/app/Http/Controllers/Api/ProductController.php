<?php

// app/Http/Controllers/Api/ProductController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return response()->json(['products' => $products], 200);
    }

    public function store(ProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());
        return response()->json(['product' => $product], 201);
    }

    public function show($id)
    {
        $product = $this->productService->getProductById($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json(['product' => $product], 200);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = $this->productService->updateProduct($id, $request->validated());
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json(['product' => $product], 200);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->productService->deleteProduct($id);
        if (!$result) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json(['message' => 'Product soft deleted successfully'], 200);
    }
}

